<?php
declare(strict_types=1);
namespace Qcm\Logic;
use \Qcm\Helpers\Database;
require_once("./Classes/Helpers/Database.php");

session_start();
$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
$user = $db->connexion_utilisateur($_POST['login'], $_POST['mdp']);
if($user == null && !isset($_SESSION["erreur_sql"]))
{
    $_SESSION["erreur_sql"] = "Identifiants incorrects";
}
else
{
    $_SESSION["user"] = $user;
}

header('Location: ' . $_SESSION['basepath']);
exit;
