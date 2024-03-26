<?php
session_start();
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");

if(isset($_SESSION['qcm']))
{
    // Models
    $qcm_model = new QcmModel();
    $question_model = new QuestionModel();
    $prop_model = new PropositionModel();

    // On récupère le qcm et les question associées
    $qcm = $qcm_model->get_qcm((int)$_SESSION['qcm']);
    $questions = $question_model->get_qcm_questions($qcm->get_id_qcm());
    // Affichage du titre
    $index_question = 1;
    echo '<h3>' . $qcm->get_libellé_qcm() . '</h3>';
    
    
    // Début du formulaire
    echo '<form method="post" name="jeu" action="router.php">';
    // Affichage des questions
    foreach($questions as $question)
    {
        echo '<br/><p>- Question n°' . $index_question++ . ': ' . $question->get_libellé_question() . '</p>';
        $propositions = $prop_model->get_question_propositions($question->get_id_question());
        // Affichage des propositions
        foreach($propositions as $proposition)
        {
            echo '<input type="checkbox" name="' . $question->get_id_question() . '[]" id="' . $proposition->get_id_proposition() . '" value="' . $proposition->get_id_proposition() . '"';
            
            echo '/><label for="' . $proposition->get_id_proposition() . '">' . $proposition->get_libellé_proposition() . '</label><br>';
        }
    }

    echo '<input type="hidden" name="page" value="traitement"/>';
    echo '<input type="submit" value="Valider">';
    // Fin du form
}