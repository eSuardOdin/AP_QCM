<form method="post">
    <label for="login">Login : </label>
    <input type="text" id="login" name="login">
    <label for="mdp">Mot de passe : </label>
    <input type="password" id="mdp" name="mdp">
    <input type="submit" value="Connexion"/>
</form>

<?php
session_start();
use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");
// --------------------------------- Vieille connexion -----------------------
/*
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
        $_SESSION["role"] = $db->get_role_utilisateur($user["IdUtilisateur"]);

        header('Location: index.php');
        exit;
    }
}*/
// --------------------------------------------------------------------------


// --------------------------------- Nouvelle connexion ----------------------

if(isset($_SESSION["erreur_sql"]))
{
    echo $_SESSION["erreur_sql"];
    $_SESSION["erreur_sql"] = null;
}
if(isset($_POST["login"]))
{
    $model = new UtilisateurModel();
    $id = $model->check_credentials($_POST['login'], $_POST['mdp']);
    if($id === -1 && !isset($_SESSION["erreur_sql"]))
    {
        $_SESSION["erreur_sql"] = "Identifiants incorrects";
    }

    // Attribution des infos user
    else
    {
        $user = $model->get_utilisateur($id);
        $_SESSION["user"]["IdUtilisateur"] = $user->get_id_utilisateur();
        $_SESSION["user"]["Login"] = $user->get_login();
        $_SESSION["user"]["Nom"] = $user->get_nom();
        $_SESSION["user"]["Prénom"] = $user->get_prénom();

        $_SESSION["role"] = $model->get_role_utilisateur($user->get_id_utilisateur());

        // // Test élève
        // if($_SESSION["role"] == "Elève")
        // {
        //     $_SESSION["page"] = "élève/tableau_bord.php";
        // }
        header('Location: index.php');
        exit;
    }
}
// --------------------------------------------------------------------------
