<?php
echo '<pre>';
echo var_dump($_POST);
echo '</pre>';
session_start();
// $_SESSION['page'] = null;
if (isset($_REQUEST["page"]))
{
    switch($_REQUEST["page"]){
        // -------------------------------------
        case "Affectation d'un QCM":
            $_SESSION["page"] = "enseignant/affectation_qcm.php";
            // Si form est post
            if (isset( $_POST["qcm"]) && count($_POST["affecte_qcm"]) > 0)
            {
                $_SESSION["affectation"]['id_qcm'] = $_POST["qcm"];
                $_SESSION["affectation"]['date'] = $_POST['date'];
                $_SESSION["affectation"]['affectés'] = $_POST["affecte_qcm"];
            }
            
            break;

        // -------------------------------------
        case "Résultats":
            $_SESSION["page"] = "enseignant/affectation_qcm.php";
            break;
        
        // -------------------------------------
        // Gestion QCM
        case "Gestion des QCM":
            $_SESSION["page"] = "enseignant/gestion_qcm/menu.php";
            break;
        // Afficher 
        case "Afficher QCM":
            $_SESSION["page"] = "enseignant/gestion_qcm/afficher_qcm.php";
            // Get l'id du qcm dans la session
            if (isset($_REQUEST["qcm"]) && $_REQUEST["qcm"] != null)
            {
                $_SESSION["qcm"] = $_REQUEST["qcm"];
            }
            break;
        // Supprimer
        case "Supprimer QCM": // Afficher le formulaire de suppression des QCM
            $_SESSION["page"] = "enseignant/gestion_qcm/supprimer_qcm.php";
            break;
        case "Supprimer QCM(s)": // Lancer la logique de suppression
            if (isset($_REQUEST["del_qcm"]) && $_REQUEST["del_qcm"] != null)
            {
                $_SESSION["del_qcm"] = $_REQUEST["del_qcm"];
                $_SESSION["page"] = "enseignant/gestion_qcm/confirmation_supprimer_qcm.php";
            }
            break;
        // Ajouter
        case "Ajouter QCM":
            $_SESSION["page"] = "enseignant/gestion_qcm/ajouter_qcm.php";
            break;
        // Modifier
        case "Modifier QCM":
            $_SESSION["page"] = "enseignant/gestion_qcm/modifier_qcm.php";
            break;
        // -------------------------------------
        // Gestion des comptes
        case "Gestion des comptes":
            $_SESSION["page"] = "enseignant/gestion_comptes/menu.php";
            if (isset($_SESSION['suppression']))
            {
                $_SESSION['suppression'] = null;
            }
            break;
        case "Ajouter un compte":
            $_SESSION["page"] = "enseignant/gestion_comptes/inscription.php";
            // Si le form est rempli, on l'affecte à la session
            if(isset($_POST["login"]))
            {
                $_SESSION["post"] = $_POST;
            }
            break;
        case "Supprimer un compte":
            if(!isset($_SESSION["suppression"]) || $_SESSION["suppression"] == null ){
                $_SESSION["suppression"] = (int)$_POST["suppression"];
            } 
            $_SESSION["page"] = "enseignant/gestion_comptes/suppression.php";
            if(isset($_POST["del"]))
            {
                $_SESSION["del"] = true;
            }
            break;
        // -------------------------------------
        case "Gestion des groupes":
            $_SESSION["page"] = "enseignant/gestion_groupes.php";
            break;

        // -------------------------------------
        // ELEVE
        case "Tableau de bord":
            $_SESSION["page"] = "élève/tableau_bord.php";
            break;
        case "Afficher":
            $_SESSION['qcm'] = $_POST['qcm'];
            $_SESSION['résultat'] = $_POST['résultat'];
            $_SESSION["page"] = "élève/synthèse.php";
            break;
        case "Réaliser":
            $_SESSION['qcm'] = $_POST['qcm'];
            $_SESSION['résultat'] = $_POST['résultat'];
            $_SESSION["page"] = "élève/jeu.php";
            break;
        // Traitement du qcm
        case "traitement":
            // Get les réponses
            $_SESSION['qcm'] = [];
            foreach($_POST as $key => $value)
            {
                if($key != "page")
                {
                    array_push($_SESSION['qcm'], [
                        "question" => $key,    
                        "reponses" => $value
                    ]);
                }
            }
            $_SESSION["page"] = "élève/traitement.php";
            break;

        // -------------------------------------
        // COMMUN
        case "Déconnexion":
            $_SESSION["page"] = "deconnexion.php";
            break;
        default:
            break;
    }
    header("Location: index.php");
}
