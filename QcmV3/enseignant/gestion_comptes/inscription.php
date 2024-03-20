<form method="post" action="router.php">
    <input name="page" type="hidden" value="Gestion des comptes"/>
    <input type="submit" value="Retour"/>
</form>

<h1>Création de compte</h1>


<?php
session_start();
if(!isset($_SESSION["added_user"]))
{
    echo '
    <form method="post" action="../../Logic/inscription.php">
    
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