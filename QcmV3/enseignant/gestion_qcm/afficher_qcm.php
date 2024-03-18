<?php
session_start();
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");

// Get les qcm
$qcm_model = new QcmModel();
$qcms = $qcm_model->get_all_qcm();
// $db = new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
// $qcms = $db->get_all_qcm();

// Selection du qcm
echo '
<form method="post" action="router.php">
<input type="hidden" name="page" value="Afficher QCM"/>
<select name="qcm">
';
foreach($qcms as $qcm)
{
    echo '<option value="'.$qcm->get_id_qcm().'">'.$qcm->get_libellé_qcm().'</option>';
}
echo '</select><input type="submit" value="Afficher"></form>';


// Si on a validé l'affichage d'un qcm
if(isset($_SESSION['qcm']))
{
    // Models
    $qcm_model = new QcmModel();
    $question_model = new QuestionModel();
    $prop_model = new PropositionModel();

    // On récupère le qcm et les question associées
    $qcm = $qcm_model->get_qcm((int)$_SESSION['qcm']);
    $questions = $question_model->get_qcm_questions($qcm->get_id_qcm());
    $auteur = $qcm->get_auteur();
    // Affichage du titre
    $index_question = 1;
    echo '<h3>' . $qcm->get_libellé_qcm() . '</h3>';
    echo '<p>Auteur: <u>' . $auteur['nom'] . ' ' . $auteur['prénom'] . ' (' . $auteur['login'] . ')</u></p>';
    // Affichage des questions
    foreach($questions as $question)
    {
        echo '<br/><p>- Question n°' . $index_question++ . ': ' . $question->get_libellé_question() . '</p>';
        $propositions = $prop_model->get_question_propositions($question->get_id_question());
        // Affichage des propositions
        foreach($propositions as $proposition)
        {
            echo '<input type="checkbox" disabled id="' . $proposition->get_id_proposition() . '"';
            if($proposition->get_résultat_vrai_faux())
            {
                echo ' checked';
            }
            echo '/><label for="' . $proposition->get_id_proposition() . '">' . $proposition->get_libellé_proposition() . '</label><br>';
        }
    }
}
