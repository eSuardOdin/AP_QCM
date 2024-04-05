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


$reponse_model = new RéponseModel();
$resultat_model = new RésultatModel();
$resultat = $resultat_model->get_résultat($_SESSION['résultat']);


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
    // Ajouter les propositions dans la db
    foreach($rep['reponses'] as $r)
    {
        $reponse_model->save_réponse((int)$_SESSION['résultat'], (int)$r);
    }
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


// Modif du résultat
$resultat->set_note($note);
// Set de la date de réalisation
$resultat->set_date_réalisation(date("Y-m-d"));

// On push le resultat et get le statut du push dans la db
$update_status = $resultat_model->update_résultat($resultat);


if($update_status == 0)
{
    echo '<p>Votre résultat a bien été enregistré.</p>';
}
else
{
    echo '<p>Il y a eu une erreur lors de l\'insertion du résultat dans la base de données.</p>';
}

$_SESSION['qcm'] = null;
// Insertions des données



// echo '<br/><br/><br/>';
// echo '<h4>Affectation: ' . date('U', strtotime($resultat->get_date_affectation())) . '<br/>';
// echo '<h4>Réalisation: ' . date('U', strtotime($resultat->get_date_réalisation())) . '<br/>';