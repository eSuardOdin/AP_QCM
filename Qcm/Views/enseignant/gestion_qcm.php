<form method="post" action="../../Logic/router.php">
    <input name="qcm_submenu" type="submit" value="Afficher QCM"/>
    <input name="qcm_submenu" type="submit" value="Supprimer QCM"/>
    </form>
<?php
session_start();
if(!isset($_SESSION['qcm_submenu']))
{
    $_SESSION['qcm_submenu'] = "enseignant/afficher_qcm.php";
}

include_once($_SESSION['qcm_submenu']);
$_SESSION['qcm_submenu'] = null;