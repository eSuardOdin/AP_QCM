<?php
declare(strict_types= 1);
session_start();
unset($_SESSION["user"]);
unset($_SESSION["page"]);
header('Location: ' . $_SESSION['basepath']);
exit;