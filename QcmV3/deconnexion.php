<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['role']);
unset($_SESSION['qcm']);
unset($_SESSION['qcm_form']);
unset($_SESSION['affectation']);




unset($_SESSION['test']);

header('Location: index.php');
exit();