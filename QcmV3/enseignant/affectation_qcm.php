<?php
use Qcm\Classes\Résultat;
// include_once("Classes/Résultat.php");
session_start();
use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");


/*
    Si le form est rempli
    structure de la variable :
    [
        id_qcm : int,
        date_affectation: date,
        affectés : [int, int, int]
    ]
*/

$user_model = new UtilisateurModel();
$qcm_model = new QcmModel();
$res_model = new RésultatModel();
if(isset($_SESSION["affectation"]))
{

    // Logique d'affectation
    echo '<pre>';
    echo var_dump($_SESSION['affectation']);
    echo '</pre>';
    echo '<form method="post" action="router.php"><input type="hidden" name="page" value="Affectation d\'un QCM"/><input type="submit" value="Retour"/><br/>';
    $id_qcm = (int)$_SESSION["affectation"]["id_qcm"];
    foreach($_SESSION["affectation"]["affectés"] as $id_user)
    {
        // Si l'utilisateur n'avait pas déjà une affectation
        // if($res_model->get_qcm_élève_résultat($id_qcm, $id_user) == null)
        // {
            
        $id_res = $res_model->create_résultat($_SESSION["affectation"]["date"], (int)$id_user, (int)$id_qcm, (int)$_SESSION["user"]["IdUtilisateur"]);
        if($id_res > 0)
        {
            echo '- Le qcm a bien été affecté à ' . $user_model->get_utilisateur($id_user)->get_nom() . ' ' . $user_model->get_utilisateur($id_user)->get_prénom() . '<br/>';
        }
        else if($id_res == -1)
        {
            echo '- Le qcm était déjà affecté à ' . $user_model->get_utilisateur($id_user)->get_nom() . ' ' . $user_model->get_utilisateur($id_user)->get_prénom() . '<br/>';
        }
        // }
    }

    // Reset
    unset($_SESSION['affectation']);
}

/**
 * Sinon: affichage du formulaire
 */
else
{
    
    $qcms = $qcm_model->get_all_qcm();
    if(count($qcms) == 0)
    {
        echo '<h2>Aucun QCM à affecter</h2>';
    }
    else
    {
        // Affichage des QCM
        echo '
        <form method="post" action="router.php">
        <label for="qcm">Selection du QCM : </label>
        <select name="qcm">
        ';
    
        foreach($qcms as $qcm)
        {
            echo '<option value="'.$qcm->get_id_qcm().'">'.$qcm->get_libellé_qcm().'</option>';
        }
        echo '
            </select><br/><br/>
            <label for="date">Date d\'affectation : </label>
            <input required type="date" name="date"/><br/><br/>
        ';

        // Affichage du tableau des utilisateurs
        $users = $user_model->get_all_utilisateurs();


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
                <th>Type</th>
                <th>Affectation</th>
            </tr>
            ';
            foreach($users as $user)
            {
                echo '<tr>';
                echo '<td>' . $user->get_id_utilisateur() . '</td>';
                echo '<td>' . $user->get_nom() . '</td>';
                echo '<td>' . $user->get_prénom() . '</td>';
                echo '<td>' . $user_model->get_role_utilisateur($user->get_id_utilisateur()) . '</td>';
               
                
                echo '
                <td>
                    <input type="checkbox" name="affecte_qcm[]" id="'. $user->get_id_utilisateur() . '" value="'. $user->get_id_utilisateur() . '">
                </td>';
            
                echo '</tr>';
            }
            echo '</table><br/><br/><input type="submit" value="Affecter"/>
            <input type="hidden" name="page" value="Affectation d\'un QCM"/></form>';

        }
    }
}