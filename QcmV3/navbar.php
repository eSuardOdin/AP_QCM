<link rel="stylesheet" href=<?php echo $_SESSION["basepath"] . "style.css?v="?><?php echo time(); ?>>


<?php
session_start();

// $base_url = $_SERVER['DOCUMENT_ROOT'];
if($_SESSION['user']['role'] == "Enseignant")
{
    echo '
    <form style="text-align: center;" method="post" action="router.php">
        <input name="page" class="btn-link" type="submit" value="Affectation d\'un QCM"/> -
        <input name="page" class="btn-link" type="submit" value="Résultats"/> -
        <input name="page" class="btn-link" type="submit" value="Gestion des QCM"/> -
        <input name="page" class="btn-link" type="submit" value="Gestion des comptes"/> -
        <input name="page" class="btn-link" type="submit" value="Gestion des groupes"/> -
        <input name="page" class="btn-link" type="submit" value="Déconnexion"/>
    </form> ';

// echo '<a href="'.$base_url.'/enseignant/affectation_qcm.php">Affectation d\'un QCM</a> - 
// <a href="'.$base_url.'/enseignant/resultats.php">Résultats</a> - 
// <a href="'.$base_url.'/enseignant/gestion_qcm/menu.php">Gestion des QCM</a> - 
// <a href="'.$base_url.'/enseignant/gestion_comptes.php">Gestion des comptes</a> - 
// <a href="'.$base_url.'/enseignant/gestion_groupes.php">Gestion des groupes</a> - 
// <a href="'.$base_url.'/deconnexion.php">Se déconnecter</a>';

}

else if($_SESSION['user']['role'] == "Elève")
{
    echo '
    <form style="text-align: center;" method="post" action="router.php">
        <input name="page" class="btn-link" type="submit" value="Déconnexion"/>
    </form> ';
}
?>


