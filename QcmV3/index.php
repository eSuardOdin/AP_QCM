<link rel="stylesheet" href=<?php echo $_SESSION["basepath"] . "style.css?v="?><?php echo time(); ?>>
<?php
session_start();
// $_SESSION["basepath"] = "http://qcm.suard/";
$_SESSION["basepath"] = "http://localhost:5000/";

// Si l'utilisateur existe et est bien enseignant ou élève
if(!isset($_SESSION["user"]) || $_SESSION["role"] == "Rôle inconnu"){
    include_once("login.php");
} 
else {
    echo '
    <div style="display: flex; justify-content: space-around;">
        <p>Application QCM</p>
        <p>Utilisateur: ' . $_SESSION['user']['Prénom'] . ' ' . $_SESSION['user']['Nom'] . '</p>' . '
        <p>Type: ' . $_SESSION['role'] . '</p>' . '
    </div>
    ';
    include_once('accueil.php');
}


echo'<br/><br/><hr/><h3>Débug</h3><hr/>';
echo'<pre>';
echo var_dump($_SESSION);
echo'</pre>';

$_SESSION['page'] = null;

