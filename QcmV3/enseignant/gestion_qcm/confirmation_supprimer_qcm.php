<?php
session_start();
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");

if(isset($_SESSION['del_qcm']) && $_SESSION['del_qcm'] != null)
{
    echo '<br/><br/>';
    // Ajouter vérification de la suppression dans ma méthode
    foreach($_SESSION['del_qcm'] as $id)
    {
        $model = new QcmModel();
        $qcm = $model->get_qcm((int)$id);
        echo '<br/><p>- Le QCM <i>"'. $qcm->get_libellé_qcm() . '"</i> a été supprimé.</p>';
        $model->delete_qcm($id);
    }
    $_SESSION['del_qcm'] = null;
}
?>

<form method="post" action="router.php">
    <input type="hidden" name="page" value="Supprimer QCM"/>
    <input type="submit" value="Retour"/>
</form>