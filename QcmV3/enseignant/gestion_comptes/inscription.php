<form method="post" action="router.php">
    <input name="page" type="hidden" value="Gestion des comptes"/>
    <input type="submit" value="Retour"/>
</form>

<h1>Création de compte</h1>


<?php
session_start();


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

// Si le formulaire a été envoyé
if (isset($_SESSION['post']))
{
    echo '<pre>';
    echo var_dump($_SESSION['post']);
    echo '</pre>';
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