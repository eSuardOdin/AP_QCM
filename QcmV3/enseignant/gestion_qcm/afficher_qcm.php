<?php
session_start();
use Qcm\Helpers\Database;
include_once("Classes/Helpers/Database.php");
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");

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

if(isset($_SESSION['qcm']))
{
    $qcm_model = new QcmModel();
    echo '<pre>';
    echo var_dump( $qcm_model->get_qcm((int)$_SESSION['qcm']) );
    echo var_dump( $qcm_model->get_all_qcm() );
    echo '</pre>';
}
