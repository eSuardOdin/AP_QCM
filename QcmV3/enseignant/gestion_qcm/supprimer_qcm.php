<?php
session_start();
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");

$qcms = (new QcmModel())->get_all_qcm();

if($qcms == null)
{
    echo"<h3>Pas de QCM à supprimer</h3>";
}
else
{
    echo '<form method="post" action="router.php">';
    foreach($qcms as $qcm)
    {
        echo '<input type="checkbox" name="del_qcm[]" id="'. $qcm->get_id_qcm() . '" value="' . $qcm->get_id_qcm() . '">';
        echo '<label for="' . $qcm->get_id_qcm() . '">' . $qcm->get_libellé_qcm().'</label><br/>';

    }
    echo '<br/><input type="submit" name="page" value="Supprimer QCM(s)"/></form>';
}

// if(isset($_SESSION['del_qcm']) && $_SESSION['del_qcm'] != null)
// {
//     echo '<br/><br/>';
//     // Ajouter vérification de la suppression dans ma méthode
//     foreach($_SESSION['del_qcm'] as $id)
//     {
//         $model = new QcmModel();
//         $qcm = $model->get_qcm((int)$id);
//         echo '<br/><p>- Le QCM <i>"'. $qcm->get_libellé_qcm() . '"</i> a été supprimé.</p>';
//         $model->delete_qcm($id);
//     }
//     $_SESSION['del_qcm'] = null;
// }