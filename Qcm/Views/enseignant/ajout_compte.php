<form method="post" action="../../Logic/router.php">
    <input name="page" type="hidden" value="Gestion des comptes"/>
    <input type="submit" value="Retour"/>
</form>

<h1>Création de compte</h1>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <label for="nom">Nom : </label> 
    <input required type="text" name="nom"/>
    <?php echo $nameErr;?>
    <br><br>

    <label for="prénom">Prénom : </label> 
    <input required type="text" name="prénom">
    <br><br>

    <label for="login">Login : </label>
    <input required type="text" name="login">
    <?php echo $emailErr;?>
    <br><br>

    <label for="role">Rôle : </label>
    <input required type="radio" name="role" value="élève">Elève</input>
    <input required type="radio" name="role" value="enseignant">Enseignant</input>
    <br><br>
    <input type="submit" name="submit" value="Inscrire">

</form>

<?php

echo '<pre>';
echo var_dump($_REQUEST);
echo '</pre>';