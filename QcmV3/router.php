<?php
echo '<pre>';
echo var_dump($_POST);
echo '</pre>';
session_start();
// $_SESSION['page'] = null;
if (isset($_REQUEST["page"]))
{
    switch($_REQUEST["page"]){
        case "Affectation d'un QCM":
            // header("Location: ".$_SESSION['base_url']."enseignant/affectation_qcm.php");
            $_SESSION["page"] = "enseignant/affectation_qcm.php";
            break;
        case "Résultats":
            // header("Location: ".$_SESSION['base_url']."enseignant/résultats.php");
            $_SESSION["page"] = "enseignant/affectation_qcm.php";
            break;
        
        // QCM
        case "Gestion des QCM":
            // header("Location: ".$_SESSION['base_url']."enseignant/gestion_qcm/menu.php");
            $_SESSION["page"] = "enseignant/gestion_qcm/menu.php";
            break;
        case "Afficher QCM":
            $_SESSION["page"] = "enseignant/gestion_qcm/afficher_qcm.php";
            // Get l'id du qcm dans la session
            if (isset($_REQUEST["qcm"]) && $_REQUEST["qcm"] != null)
            {
                $_SESSION["qcm"] = $_REQUEST["qcm"];
            }
            break;
        case "Supprimer QCM":
            $_SESSION["page"] = "enseignant/gestion_qcm/supprimer_qcm.php";
            break;

        // Comptes
        case "Gestion des comptes":
            $_SESSION["page"] = "enseignant/gestion_comptes.php";
            break;
        case "Ajouter un compte":
            $_SESSION["page"] = "enseignant/ajout_compte.php";
            break;
        case "Gestion des groupes":
            $_SESSION["page"] = "enseignant/gestion_groupes.php";
            break;
        case "Déconnexion":
            $_SESSION["page"] = "deconnexion.php";
            break;
        default:
            break;
    }
    header("Location: index.php");
}
