<?php
 
if ($_SESSION['user']['role'] == "Enseignant")
{
    include_once("Views/enseignant/navbar.php");
}
else if ($_SESSION["user"]["role"] == "Elève")
{
    include_once("Views/eleve/navbar.php");
}
echo "hello" . $_SESSION['user']['login'];
?>
<!-- Form logout -->
<form method="post" action="Logic/disconnect.php">
<input type="submit" value="Déconnexion"/>
</form>