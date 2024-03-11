<?php

/*
echo '<form method="post" action="test_inscription.php">
    <input type="text" id="nom" name="nom" />
    <input type="text" id="prénom" name="prénom" />
    <input type="text" id="login" name="login" />
    <input type="password" id="mdp" name="mdp" />
    <input type="submit" value="Inscrire">
</form>';
if(isset($_SESSION["erreur_sql"])) {
    echo "Erreur lors de la création du compte : " . $_SESSION["erreur_sql"];
    $_SESSION["erreur_sql"] = null;
}*/

session_start();
// $_SESSION["basepath"] = "http://qcm.suard/";
$_SESSION["basepath"] = "http://localhost:5000/";
if(!isset($_SESSION["user"]) || $_SESSION["user"]["role"] == "Rôle inconnu"){
    include_once("Views/login.php");
} 
else {
    include_once("Views/menu.php");
}


