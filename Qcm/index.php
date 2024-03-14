<?php
session_start();
// $_SESSION["basepath"] = "http://qcm.suard/";
$_SESSION["basepath"] = "http://localhost:5000/";

// Si l'utilisateur existe et est bien enseignant ou élève
if(!isset($_SESSION["user"]) || $_SESSION["user"]["role"] == "Rôle inconnu"){
    include_once("Views/login.php");
} 
else {
    include_once('Views/menu.php');
}

echo'<br/><br/>';
echo'<pre>';
echo var_dump($_SESSION);
echo'</pre>';


