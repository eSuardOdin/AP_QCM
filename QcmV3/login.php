<form method="post">
    <label for="login">Login : </label>
    <input type="text" id="login" name="login">
    <label for="mdp">Mot de passe : </label>
    <input type="password" id="mdp" name="mdp">
    <input type="submit" value="Connexion"/>
</form>

<?php
session_start();
include_once("Classes/Helpers/Database.php");

if(isset($_SESSION["erreur_sql"]))
{
    echo $_SESSION["erreur_sql"];
    $_SESSION["erreur_sql"] = null;
}
echo "<pre>";
    echo var_dump($_REQUEST);
    // echo var_dump($db);
    echo "</pre>";
if(isset($_POST["login"]))
{
    echo "ici";
    $db =  new Qcm\Helpers\Database("localhost", "root", "E12alt%F4", "qcm_V3" );
    $user = $db->connexion_utilisateur($_POST['login'], $_POST['mdp']);

    echo "<pre>";
    echo var_dump($user);
    // echo var_dump($db);
    echo "</pre>";
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