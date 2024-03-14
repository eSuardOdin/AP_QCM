<?php
declare(strict_types= 1);
session_start();

// Route dans la $_SESSION
if (isset($_REQUEST["page"]))
{
    switch($_REQUEST["page"]){
        case "Affectation d'un QCM":
            $_SESSION["page"] = "enseignant/affectation_qcm.php";
            break;
        case "Résultats":
            $_SESSION["page"] = "enseignant/résultats.php";
            break;
        
        // QCM
        case "Gestion des QCM":
            $_SESSION["page"] = "enseignant/qcm/gestion_qcm.php";
            break;
        case "Afficher QCM":
            $_SESSION["page"] = "enseignant/qcm/afficher_qcm.php";
            break;
        case "Supprimer QCM":
            $_SESSION["page"] = "enseignant/qcm/supprimer_qcm.php";
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
            $_SESSION["page"] = "Logic/disconnect.php";
            break;
        default:
            break;
    }
}

// Test sous-page QCM
if (isset($_REQUEST["qcm_submenu"]))
{
    switch($_REQUEST["qcm_submenu"])
    {
        case "Afficher QCM":
            $_SESSION["qcm_submenu"] = "afficher_qcm.php";
            break;
        case "Supprimer QCM":
            $_SESSION["qcm_submenu"] = "supprimer_qcm.php";
            break;
    }
}
// Redirection
header('Location: ' . $_SESSION['basepath']);
exit;