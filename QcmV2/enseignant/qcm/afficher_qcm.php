<form method="post" action="../../Logic/router.php">
    <input name="page" type="hidden" value="Gestion des QCM"/>
    <input type="submit" value="Retour"/>
</form>
<?php
session_start();

use \Qcm\Helpers\Database;
require_once("Classes/Helpers/Database.php");
// $db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
session_start();

$qcms = $db->get_all_qcm();

// Select du QCM
echo '<form method="post" style="display: inline"><select name="qcm">';
foreach ($qcms as $qcm) {
    echo '<option value="' . $qcm['IdQCM'] . '">' . $qcm['LibelléQCM'] .'</option>';
}
echo '<input type="submit" value="Afficher le QCM"></select></form>';



// Si QCM selectionné
if(isset($_POST['qcm'])) {
    $qcm = $db->get_qcm((int)$_POST['qcm']);
    // echo '<pre>';
    // echo var_dump($db->get_qcm((int) $_POST['qcm']));
    // echo '</pre>';
    echo '<h3>' . $qcm->get_libellé_qcm() . '</h3>';
    echo '<p>' . $db->get_auteur_qcm($qcm->get_id_auteur()) . '</p>';
}