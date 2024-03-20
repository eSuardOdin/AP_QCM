<link rel="stylesheet" href=<?php echo $_SESSION["basepath"] . "style.css?v="?><?php echo time(); ?>>
<?php
session_start();
use \Qcm\Helpers\Database;
require_once("Classes/Helpers/Database.php");
// $_SESSION["basepath"] = "http://qcm.suard/";
$_SESSION["basepath"] = "http://localhost:5000/";

// Si l'utilisateur existe et est bien enseignant ou élève
if(!isset($_SESSION["user"]) || $_SESSION["role"] == "Rôle inconnu"){
    include_once("login.php");
} 
else {
    include_once('accueil.php');
}


echo'<br/><br/><hr/><h3>Débug</h3><hr/>';
echo'<pre>';
echo var_dump($_SESSION);
echo'</pre>';

$_SESSION['page'] = null;

