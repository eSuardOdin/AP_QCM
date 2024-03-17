<?php
session_start();
use Qcm\Helpers\Database;
include_once("Classes/Helpers/Database.php");
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

    // Affichage
    echo '<h3>' . $qcm->get_libellé_qcm() . '</h3>';
    echo '<pre>';
    echo var_dump($qcm);
    echo '<br/><br/>';
    echo var_dump( $questions );
    echo '</pre>';
}
