<?php
session_start();

use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");
use Qcm\Models\ThèmeModel;
include_once("Models/ThèmeModel.php");
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");
use Qcm\Models\RéponseModel;
include_once("Models/RéponseModel.php");


$reponse_model = new RéponseModel();
$res_model = new RésultatModel();
$qcm_model = new QcmModel();
$question_model = new QuestionModel();
$prop_model = new PropositionModel();

// Get le qcm
$qcm = $qcm_model->get_qcm((int)$_SESSION['qcm']);
// Get le résultat associé
$resultat = $res_model->get_résultat(
    $res_model->get_qcm_élève_résultat($qcm->get_id_qcm(), (int)$_SESSION['user']['IdUtilisateur'])
);
// Get les questions
$questions = $question_model->get_qcm_questions($qcm->get_id_qcm());
// Get les réponses du joueur
$reponses = $reponse_model->get_réponses_from_résultat($resultat->get_id_résultat());
// Get les points par question
$question_number = count($questions);
$points = 20 / $question_number; 
// Infos basiques
echo '<div class="align"><p>QCM n°' . $qcm->get_id_qcm() . ':</p><p>Libellé: ' . $qcm->get_libellé_qcm() . '</p>';
echo '<p>Thème: ' . (new ThèmeModel())->get_thème($qcm->get_id_thème())->get_description() . '</p>';
echo '<p>Nombre de questions: ' . $question_number . '</p>';
echo '</div>';

// Tableau question
echo '
<div class="align">
<table>
    <tr>
        <th>Question N°</th>
        <th>Validée</th>
        <th>Points</th>
    </tr>
';


$index_question = 1;
// On a les questions, pour chacune :
foreach($questions as $q)
{
    $points_question = 1;
    $valide = "Oui";

    echo '<tr>';
    // - On affiche le n°
    echo '<td>' . $index_question . '</td>';
    // Get toutes les réponses justes (foreach pour n'avoir que les ID)
    $reponses_justes = [];
    foreach($prop_model->get_question_propositions_justes($q->get_id_question()) as $p)
    {
        array_push($reponses_justes, $p->get_id_proposition());    
    }
    
    // Get les réponses du joueur sur la question (foreach pour n'avoir que les ID)
    $reponses_joueur = [];
    foreach($reponse_model->get_réponses_from_question($resultat->get_id_résultat(), $q->get_id_question()) as $r)
    {
        array_push($reponses_joueur, $r->get_id_proposition());    
    }
    
    // - On check si le joueur a répondu a la question, si non          "Validée: NON"
    if(count($reponses_joueur) == 0)
    {
        $points_question = 0;
        $valide = "Non";
    }
    else
    {
        // - On check si une des réponses fournies par le joueur est fausse "Validée: NON"
        foreach($reponses_joueur as $r)
        {
            if(!in_array($r, $reponses_justes))
            {
                $points_question = 0;
                $valide = "Non";

                break;
            }
        }
    }
    // - Si non, si toutes les réponses justes ne sont pas  fournies    "Validée: PARTIEL"
    if($valide == "Oui" && count($reponses_joueur) != count($reponses_justes))
    {
        $valide = "Partiel";
        $points_question = 1 * (count($reponses_joueur) / count($reponses_justes));
    }
    echo '<td>' . $valide . '</td>';
    echo '<td>' . $points_question . '</td>';
    echo '</tr>';
    $index_question++;
}
echo '</table></div>';

// Note et pourcentage
echo '
<div class="align">
    <table><tr><th>Note</th><td>'.($resultat->get_note() / 5).'/20</td></tr></table>
    <table><tr><th>Réalisé</th><td>'.$resultat->get_note().'%</td></tr></table>';


echo '</div><form method="post" action="router.php"><input type="submit" name="page" value="Tableau de bord"/>';