<?php
session_start();
include_once("navbar.php");
if(!isset($_SESSION['page'])/* && $_SESSION['role'] == "Enseignant"*/)
{
    // if($_SESSION['role'] == "Elève")
    // {
    //     $_SESSION['page'] = "élève/tableau_bord.php";
    // }
    // else
    // {
        echo "<h1>Bienvenue sur l'application QCM</h1>";
    // }
}
else
{
    // if($_SESSION['role'] == "Elève")
    // {
    //     $_SESSION['page'] = "élève/tableau_bord.php";
    // }
    include_once($_SESSION['page']);
}
