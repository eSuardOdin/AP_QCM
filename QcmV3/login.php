<form method="post">
    <label for="login">Login : </label>
    <input type="text" id="login" name="login">
    <label for="mdp">Mot de passe : </label>
    <input type="password" id="mdp" name="mdp">
    <input type="submit" value="Connexion"/>
</form>

<?php
session_start();
use Qcm\Helpers\Database;
include_once("Classes/Helpers/Database.php");

if(isset($_SESSION["erreur_sql"]))
{
    echo $_SESSION["erreur_sql"];
    $_SESSION["erreur_sql"] = null;
}


if(isset($_POST["login"]))
{
    $db = new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
    $user = $db->connexion_utilisateur($_POST['login'], $_POST['mdp']);

    // Si problème de db
    if($user == null && !isset($_SESSION["erreur_sql"]))
    {
        $_SESSION["erreur_sql"] = "Identifiants incorrects";
    }

    // Attribution des infos user
    else
    {
        $_SESSION["user"] = $user;
        $_SESSION["user"]["role"] = $db->get_role_utilisateur($user["IdUtilisateur"]);

        header('Location: index.php');
        exit;
    }
}