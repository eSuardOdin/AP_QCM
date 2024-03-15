<?php
session_start();
if ($_SESSION['user']['role'] == "Enseignant" && $_SESSION['page'] != "enseignant/ajout_compte.php")
{
    include_once("enseignant/navbar.php");
}
else if ($_SESSION["user"]["role"] == "Elève")
{
    include_once("eleve/navbar.php");
}

?>

<?php
// Page en cours
if(isset($_SESSION["page"]))
{
    require_once($_SESSION["page"]);
}

// echo '<pre>';
// echo var_dump($_SESSION);
// echo '</pre>';
