<?php
session_start();

use Qcm\Models\UtilisateurModel;
include_once("Models/UtilisateurModel.php");
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");

$res_model = new RésultatModel();
$élèves = (new UtilisateurModel())->get_all_utilisateurs("élève");

if(count($élèves) == 0)
{
    echo 'Il n\'y a pas d\'élève inscrit.';
}
else
{
    echo '<h5 class="align">Résultats par élèves</h5><div class="align"><table>';
    echo '
    <tr>
        <th>Identifiant</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Moyenne</th>
        <th>Disponibles</th>
        <th>Réalisés</th>
    </tr>
    ';
    foreach($élèves as $e)
    {
        // Get les résultats
        $res = $res_model->get_all_résultat_élève($e->get_id_utilisateur());
        echo '
        <tr>
            <td>'. $e->get_id_utilisateur() .'</td>
            <td>'. $e->get_nom() .'</td>
            <td>'. $e->get_prénom() .'</td>
        ';


        echo '
        </tr>
        ';
    }
    echo '</table></div>';
}