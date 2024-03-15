<?php
declare(strict_types=1);
namespace Qcm\Logic;

use Qcm\Helpers\Database;
require_once("../Classes/Helpers/Database.php");

session_start();

// Connexion à la db
// $db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
$user = $db->connexion_utilisateur($_POST['login'], $_POST['mdp']);

// Si problème de db
if($user == null && !isset($_SESSION["erreur_sql"]))
{
    $_SESSION["erreur_sql"] = "Identifiants incorrects";
}

// Attribution des infos user
else
{
    $_SESSION["user"] = $user;
    $_SESSION["user"]["role"] = $db->get_role_utilisateur($user["IdUtilisateur"]);

    // Direction menu
    $_SESSION['page'] = 'Views/menu.php';
}

header('Location: ' . $_SESSION['basepath']);
exit;
