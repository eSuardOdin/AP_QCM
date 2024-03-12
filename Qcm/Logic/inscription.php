<?php
declare(strict_types=1);
namespace Qcm\Logic;
use \Qcm\Helpers\Database;
require_once("../Classes/Helpers/Database.php");

$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
// $test_id = $db->add_utilisateur($_POST['nom'], $_POST['prénom'], $_POST['login'], $_POST['mdp']);
session_start();

// Check des erreurs
$regex = "/^[0-9a-zA-Z-.'\s]*$/";
$isErrorFree = true;

// Login
if (!$db->is_login_free($_POST['login']))
{
    $_SESSION["form_user_errors"]["login"] = "Le login " . $_POST['login'] . " est déjà utilisé.";
    $isErrorFree = false;
}
if(!preg_match("/^[0-9a-zA-Z-.\s]*$/", $_POST['login']))
{
    $_SESSION["form_user_errors"]["login"] = "Le login ne doit contenir que des caractères autorisés (alphanumériques, tirets et points)";
    $isErrorFree = false;
}

// Nom, prénom
if(!preg_match("/^[a-zA-Z-\s]*$/", $_POST['nom']))
{
    $_SESSION["form_user_errors"]["nom"] = "Le nom ne doit contenir que des caractères autorisés (alphabétiques et tirets )";
    $isErrorFree = false;
}
if(!preg_match("/^[a-zA-Z-\s]*$/", $_POST['prénom']))
{
    $_SESSION["form_user_errors"]["prénom"] = "Le prénom ne doit contenir que des caractères autorisés (alphabétiques et tirets )";
    $isErrorFree = false;
}

//header('Location: http://qcm.suard/');
if($isErrorFree)
{
    $_SESSION['added_user'] = $_POST['login'];
}
header('Location: ' . $_SESSION['basepath']);
exit;