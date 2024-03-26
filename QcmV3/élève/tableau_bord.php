<h1>Tableau de bord</h1>
<?php
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");

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

echo '<pre>';
echo var_dump((new RésultatModel())->get_all_résultat_élève((int)$_SESSION['user']['IdUtilisateur']));
echo '</pre>';
