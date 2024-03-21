<form method="post" action="router.php">
    <input name="page" type="hidden" value="Gestion des comptes"/>
    <input type="submit" value="Retour"/>
</form>

<?php
session_start();
use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");
$model = new UtilisateurModel();
echo "<h3>Voulez vous vraiment supprimer le compte " . $model->get_utilisateur($_SESSION['suppression'])['Login'] . "?";