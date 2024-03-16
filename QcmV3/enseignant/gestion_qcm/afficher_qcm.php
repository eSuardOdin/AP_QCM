<?php
session_start();
use Qcm\Helpers\Database;
include_once("Classes/Helpers/Database.php");

// Get les qcm
$db = new Database("localhost", "root", "E12alt%F4", "qcm_V3" );
$qcms = $db->get_all_qcm();

// Selection du qcm
echo '
<form method="post">
<select name="qcm">
';
foreach( $qcms as $qcm)
{
    echo '<option value="'.$qcm['IdQCM'].'>'.$qcm['LibelléQCM'].'</option>';
}
echo '</select></form>';