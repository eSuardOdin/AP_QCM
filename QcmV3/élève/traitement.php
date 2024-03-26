<?php
use Qcm\Classes\Résultat;
include_once("Classes/Résultat.php");
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");

use Qcm\Classes\Réponse;
include_once("Classes/Réponse.php");
use Qcm\Models\RéponseModel;
include_once("Models/RéponseModel.php");



$resultat_model = new RésultatModel();
$resultat = $resultat_model->get_résultat($_SESSION['résultat']);

// Set de la date de réalisation
$today = date("Y-m-d");
$resultat->set_date_réalisation($today);

// Trouver toutes les questions pour connaitre les points associés à une question
$question_model = new QuestionModel();
$questions = $question_model->get_qcm_questions($resultat->get_id_qcm());
$proposition_model = new PropositionModel();
// Calcul des points par question en fonction du nb de questions
$points = 100 / count($questions);

// Check les questions avec réponses
$questions_faites = [];
foreach($_SESSION['qcm'] as $rep)
{
    // Pour simplement checker si réponse sur une question
    array_push($questions_faites, $rep['question']);
}
// On part de max points et dégressif sur erreur
$note = 100;
/* 
Foreach questions : 
    - Check si on a répondu a la question, si non : 0 points
    - Si on a une mauvaise réponse : 0 points
    - Si on a une partie de bonne réponses -> partie/total points
    - Toutes les bonnes réponses : tous les points
*/
foreach($questions as $question)
{
    // Check si on a répondu a la question, si non : 0 points
    if(!in_array($question->get_id_question(), $questions_faites))
    {
        $note -= $points;
        continue;
    }
    
    // Get toutes les propositions justes
    $prop_justes = [];
    foreach($proposition_model->get_question_propositions_justes($question->get_id_question()) as $prop)
    {
        array_push($prop_justes, $prop->get_id_proposition());
    }

    // Check si on a une réponse fausse
    $error = false;
    foreach($_SESSION['qcm'] as $q)
    {
        if($q['question'] == $question->get_id_question())
        {
            foreach($q['reponses'] as $r)
            {

                if(!in_array($r, $prop_justes))
                {
                    $error = true;
                    // break;
                    // °°°°°°°°°°°°°°°°°°°°°
                    // RAJOUTER REPONSES DB ICI ?
                }
            }
            break;
        }
    }
    // Skip le reste si réponse fausse
    if($error)
    {
        $note -= $points;
        continue;
    }

    // Check si on a toutes les bonnes réponses
    $nb_reponses = count($prop_justes);
    foreach($_SESSION['qcm'] as $q)
    {
        if($q['question'] == $question->get_id_question())
        {
            // Si non, on enlève l'équivalent de points
            if(count($q['reponses']) != $nb_reponses)
            {
                $note -= $points * (($nb_reponses - count($q['reponses'])) / $nb_reponses);
            }
        }
    }
}

$resultat->set_note($note);

echo '<pre>' . var_dump($resultat) . '</pre>';

$_SESSION['qcm'] = null;
// Insertions des données



// echo '<br/><br/><br/>';
// echo '<h4>Affectation: ' . date('U', strtotime($resultat->get_date_affectation())) . '<br/>';
// echo '<h4>Réalisation: ' . date('U', strtotime($resultat->get_date_réalisation())) . '<br/>';