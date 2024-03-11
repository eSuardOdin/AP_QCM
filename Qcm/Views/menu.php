<?php
session_start();
if ($_SESSION['user']['role'] == "Enseignant")
{
    include_once("Views/enseignant/navbar.php");
}
else if ($_SESSION["user"]["role"] == "Elève")
{
    include_once("Views/eleve/navbar.php");
}

?>
<!-- Form logout -->
<form method="post" action="Logic/disconnect.php">
<input type="submit" value="Déconnexion"/>
</form>

<?php
// Page en cours
if(isset($_SESSION["page"]))
{
    require_once($_SESSION["page"]);
}

// echo '<pre>';
// echo var_dump($_SESSION);
// echo '</pre>';
