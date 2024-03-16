<?php
session_start();
include_once("navbar.php");
if(!isset($_SESSION['page']))
{
    echo "<h1>Bienvenue sur l'aererercation QCM</h1>";
}
else
{
    include_once($_SESSION['page']);
}
