<form method="post" action="../../Logic/router.php">
    <input name="page" type="hidden" value="Gestion des QCM"/>
    <input type="submit" value="Retour"/>
</form>
<?php
session_start();

// if (!isset($_SESSION["qcms"]) || $_SESSION["qcms"] == null) {
    // require_once("Logic/enseignant/qcm/afficher_qcm.php");
// }
use \Qcm\Helpers\Database;
require_once("Classes/Helpers/Database.php");
// $db =  new Database("localhost", "root", "E12alt%F4", "qcm_V2" );
$db =  new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
session_start();

$qcms = $db->get_all_qcm();

echo '<p>Test</p><form style="display: inline"><select name="qcm">';
foreach ($qcms as $qcm) {
    echo '<option value="' . $qcm['IdQCM'] . '">' . $qcm['LibelléQCM'] .'</option>';
}
echo '<input type="submit" value="Afficher le QCM"></select></form>';
