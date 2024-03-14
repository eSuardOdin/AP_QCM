<?php
declare(strict_types=1);
use \Qcm\Helpers\Database;
require_once("Classes/Helpers/Database.php");

// $db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
session_start();

$qcms = $db->get_all_qcm();

echo '<pre>';
echo var_dump($qcms);
echo '</pre>';
echo '<form style="display: inline"><select name="qcm">';
foreach ($qcms as $qcm) {
    echo '<option value="' . $qcm['IdQCM'] . '">' . $qcm['LibelléQCM'] .'</option>';
}
echo '<input type="submit" value="Afficher le QCM"></select></form>';
