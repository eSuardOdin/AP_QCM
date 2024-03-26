<?php
use Qcm\Classes\Résultat;
include_once("Classes/Résultat.php");
use Qcm\Models\RésultatModel;
include_once("Models/RésultatModel.php");


$resultat_model = new RésultatModel();
$resultat = $resultat_model->get_résultat($_SESSION['résultat']);

// Set de la date de réalisation
$today = date("Y-m-d");
$resultat->set_date_réalisation($today);

// echo '<pre>';
// echo var_dump($_SESSION['qcm']);
// echo '</pre>';
echo '<pre>';
echo var_dump($resultat);
echo '</pre>';

// Insertions des données

// Trouver toutes les questions pour connaitre les points associés à une question


echo '<br/><br/><br/>';
echo '<h4>Affectation: ' . date('U', strtotime($resultat->get_date_affectation())) . '<br/>';
echo '<h4>Réalisation: ' . date('U', strtotime($resultat->get_date_réalisation())) . '<br/>';