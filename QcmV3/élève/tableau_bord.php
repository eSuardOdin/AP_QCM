<h1>Tableau de bord</h1>
<?php
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\ThèmeModel;
include_once("Models/ThèmeModel.php");


// Get les résultats
$resultat_model = new RésultatModel();
$resultats = $resultat_model->get_all_résultat_élève((int)$_SESSION['user']['IdUtilisateur']);

if($resultats == null)
{
    echo "<h3>Vous n'avez pas encore de QCM affecté.</h3>";
}
else
{
    $qcm_model = new QcmModel();
    $thème_model = new ThèmeModel();
    echo '
    <table style="border: 1px solid black;">
    <tr>
        <th>Identifiant</th>
        <th>Thème</th>
        <th>Libellé</th>
        <th>Affecté le</th>
        <th>Note</th>
        <th>Effectué le</th>
        <th>Synthèse</th>
    </tr>';
    // Affichage des infos QCM 
    foreach($resultats as $res)
    {
        $qcm = $qcm_model->get_qcm($res->get_id_qcm());
        $thème = $thème_model->get_thème($qcm->get_id_thème());
        echo '
        <tr>
            <td>' . $qcm->get_id_qcm() . ' </td>' .'
            <td>' . $thème->get_description() . '</td>' .'
            <td>' . $qcm->get_libellé_qcm() . '</td>' .'
            <td>' . $res->get_date_affectation() . '</td>' .'
            <td>' . $res->get_note() . '</td>'
        ;
        // Si réalisé
        if($res->get_date_réalisation() != null)
        {
            echo '
            <td>'. $res->get_date_réalisation() . '
            </td>
            <td>
            <form method="post" action="router.php">
                <input type="hidden" name="qcm" value="' . $qcm->get_id_qcm() . '"/>
                <input type="submit" name="page" value="Afficher"/>
            </form>
            </td>
            ';
        }
        else
        {
            echo '
            <td>
            <form method="post" action="router.php">
                <input type="hidden" name="qcm" value="' . $qcm->get_id_qcm() . '"/>
                <input type="submit" name="page" value="Réaliser"/>
            </form>
            </td>
            <td></td>
            ';
        }
    }

    echo '
    </table>
    ';
}

// echo '<pre>';
// echo var_dump((new RésultatModel())->get_all_résultat_élève((int)$_SESSION['user']['IdUtilisateur']));
// echo '</pre>';
