<h1>Gestion des comptes</h1>

<?php
session_start();
use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");
// Affichage du tableau des utilisateurs
$model = new UtilisateurModel();
$users = $model->get_all_utilisateurs();


if($users == null)
{
    echo '
    <h2>Pas d\'utilisateurs à afficher (MAIS VOUS ETES QUI ALORS ?!)</h2>
    ';
}
else
{
    echo '
    <table style="border: 1px solid black;">
    <tr>
        <th>Identifiant</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Login</th>
        <th>Mot de passe</th>
        <th>Type</th>
        <th>Modification</th>
        <th>Suppression</th>
    </tr>
    ';
    foreach($users as $user)
    {
        echo '<tr>';
        echo '<td>' . $user["IdUtilisateur"] . '</td>';
        echo '<td>' . $user["Nom"] . '</td>';
        echo '<td>' . $user["Prénom"] . '</td>';
        echo '<td>' . $user["Login"] . '</td>';
        echo '<td>' . $user["MotDePasse"] . '</td>';
        echo '<td>' . $model->get_role_utilisateur((int) $user["IdUtilisateur"]) . '</td>';
        // Formulaire de modification
        echo '
        <td>
        <form method="post" action="router.php">
        <input type="hidden" name="modification" value="'. $user['IdUtilisateur'] . '"/>' .'
        <input type="submit" value="Modifier"/>
        </form>
        </td>';
        if($_SESSION['user']['IdUtilisateur'] != $user["IdUtilisateur"])
        {
            // Formulaire de suppression
            echo '
            <td>
            <form method="post" action="router.php">
                <input type="hidden" name="page" value="Supprimer un compte"/>
                <input type="hidden" name="suppression" value="'. $user['IdUtilisateur'] . '"/>' .'
                <input type="submit" value="Supprimer"/>
            </form>
            </td>';
        }
        else
        {
            echo '
                <td>
                    <button disabled>Supprimer</button>
                </td>';
        }
        echo '</tr>';
    }
}
?>
</table>

<form method="post" action="router.php">
    <input name="page" type="submit" value="Ajouter un compte"/>
</form>