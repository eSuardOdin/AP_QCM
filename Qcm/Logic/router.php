<?php
declare(strict_types= 1);
session_start();

// Route dans la $_SESSION
switch($_REQUEST["page"]){
    case "Affectation d'un QCM":
        $_SESSION["page"] = "enseignant/affectation_qcm.php";
        break;
    case "Résultats":
        $_SESSION["page"] = "enseignant/résultats.php";
        break;
    case "Gestion des QCM":
        $_SESSION["page"] = "enseignant/gestion_qcm.php";
        break;
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

// Redirection
header('Location: ' . $_SESSION['basepath']);
exit;