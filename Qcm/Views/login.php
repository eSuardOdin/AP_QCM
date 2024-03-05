<form method="post" action="connect.php">
    <label for="login">Login : </label>
    <input type="text" id="login" name="login">
    <label for="mdp">Mot de passe : </label>
    <input type="password" id="mdp" name="mdp">
    <input type="submit" value="Connexion"/>
</form>

<?php
session_start();
if(isset($_SESSION["erreur_sql"]))
{
    echo $_SESSION["erreur_sql"];
    $_SESSION["erreur_sql"] = null;
}