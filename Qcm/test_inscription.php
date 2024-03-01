<?php
declare(strict_types=1);
namespace Qcm\Logic;
use \Qcm\Helpers\Database;
require_once("./Classes/Helpers/Database.php");

$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
$test_id = $db->add_utilisateur($_POST['nom'], $_POST['prénom'], $_POST['login'], $_POST['mdp']);

if($test_id == -1) {
    header('Location: http://qcm.suard/');
    exit;
}