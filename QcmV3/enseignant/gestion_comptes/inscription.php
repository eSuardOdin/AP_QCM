<form method="post" action="router.php">
    <input name="page" type="hidden" value="Gestion des comptes"/>
    <input type="submit" value="Retour"/>
</form>

<h1>Création de compte</h1>


<?php
session_start();
use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");

// Si le formulaire a été envoyé
if (isset($_SESSION['post']))
{
    
    $model = new UtilisateurModel();
    // Check des erreurs
    $regex = "/^[0-9a-zA-Z-.'\s]*$/";
    $isErrorFree = true;
    
    // Login
    if (!$model->is_login_free($_SESSION['post']['login']))
    {
        // $_SESSION["form_user_errors"]["login"] = "Le login " . $_POST['login'] . " est déjà utilisé.";
        echo "Le login " . $_POST['login'] . " est déjà utilisé.</br>";
        $isErrorFree = false;
    }
    if(!preg_match("/^[0-9a-zA-Z-.\s]*$/", $_SESSION['post']['login']))
    {
        // $_SESSION["form_user_errors"]["login"] = "Le login ne doit contenir que des caractères autorisés (alphanumériques, tirets et points)";
        echo "Le login ne doit contenir que des caractères autorisés (alphanumériques, tirets et points)</br>";
        $isErrorFree = false;
    }

    // Nom, prénom
    if(!preg_match("/^[a-zA-Z-\s]*$/", $_SESSION['post']['nom']))
    {
        // $_SESSION["form_user_errors"]["nom"] = "Le nom ne doit contenir que des caractères autorisés (alphabétiques et tirets )";
        echo "Le nom ne doit contenir que des caractères autorisés (alphabétiques et tirets )</br>";
        $isErrorFree = false;
    }
    if(!preg_match("/^[a-zA-Z-\s]*$/", $_SESSION['post']['prénom']))
    {
        // $_SESSION["form_user_errors"]["prénom"] = "Le prénom ne doit contenir que des caractères autorisés (alphabétiques et tirets )";
        echo "Le prénom ne doit contenir que des caractères autorisés (alphabétiques et tirets )</br>";
        $isErrorFree = false;
    }
    
    if($isErrorFree)
    {
        // Insertion utilisateur
        $id = $model->add_utilisateur(
            $_SESSION['post']["nom"],
            $_SESSION['post']["prénom"],
            $_SESSION['post']["login"],
            "1234"
        );
        $_SESSION['added_user'] = $_SESSION['post']['login'];

        // Si ok, insertion dans la table rôle correspondante
        if ($id != -1)
        {
            $_SESSION['added_user'] .= ' (' . $_SESSION['post']['role'] . ')';
            if($_SESSION['post']['role'] == 'élève')
            {
                $model->add_élève($id);
            }
            else if($_SESSION['post']['role'] == 'enseignant')
            {
                $model->add_élève($id);
            }
        }
    }
    $_SESSION['post'] = null;
}


// Avant l'envoi du formulaire
if(!isset($_SESSION["added_user"]))
{
    echo '
    <form method="post" action=router.php>

        <input type="hidden" name="page" value="Ajouter un compte"/>

        <label for="nom">Nom : </label> 
        <input required type="text" minlength="2" maxlength="64" name="nom"/>
        <?php echo $_SESSION["form_user_errors"]["nom"];?>
        <br><br>
    
        <label for="prénom">Prénom : </label> 
        <input required type="text" minlength="2" maxlength="64" name="prénom">
        <?php echo $_SESSION["form_user_errors"]["prénom"];?>
        <br><br>
    
        <label for="login">Login : </label>
        <input required type="text" minlength="2" maxlength="64" name="login">
        <?php echo $_SESSION["form_user_errors"]["login"];?>
        <br><br>
    
        <label for="role">Rôle : </label>
        <input required type="radio" name="role" value="élève">Elève
        <input required type="radio" name="role" value="enseignant">Enseignant
        <br><br>
        <input type="submit" name="submit" value="Inscrire">
    
    </form>
    ';
}
else
{
    echo '<p>L\'utilisateur ' . $_SESSION['added_user'] .' a été rajouté avec succès.';
    $_SESSION['added_user'] = null;
}


if(isset($_SESSION["form_user_errors"]))
{
    $_SESSION["form_user_errors"] = null;
}