<form method="post" action="router.php">
    <input name="page" type="hidden" value="Gestion des comptes"/>
    <input type="submit" value="Retour"/>
</form>

<?php
session_start();
use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");
$model = new UtilisateurModel();
if($_SESSION["del"] && $model->delete_utilisateur($_SESSION['suppression']))
{
    $model->delete_utilisateur($_SESSION['suppression']);
    echo "L'utilisateur a bien été supprimé.";
    $_SESSION['suppression'] = null;
    $_SESSION['del'] = null;
}
else
{
    echo "<h3>Voulez vous vraiment supprimer le compte " . $model->get_utilisateur($_SESSION['suppression'])['Login'] . "?</h3>" . 
    "<p>Cette action est irréversible</p><br/>";
    echo '
    <form method="post" action="router.php">
        <input type="hidden" name="page" value="Supprimer un compte"/>
        <input type="submit" name="del" value="Supprimer"/>
    </form>
    ';
}
