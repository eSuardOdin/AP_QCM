<?php
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");
use Qcm\Models\ThèmeModel;
include_once("Models/ThèmeModel.php");

$thème_model = new ThèmeModel();


// Si nouveau Thème, ajout du thème à la db
// if(isset($_SESSION['qcm_form']['new_thème']))
// {
//     $id_thème = $thème_model->save_thème($_SESSION['qcm_form']['new_thème']);
//     if($id_thème != -1)
//     {
//         echo 'Le thème ' . ($thème_model->get_thème($id_thème))->get_description() . ' a été créé';
//     }
// }


// Affichage des questions :
$i_question = 1;
foreach($_SESSION['qcm_form']['questions'] as $q)
{
    echo '<h5>' . $q . '</h5>';
    foreach($_SESSION['qcm_form']['propositions'][$i_question] as $p)
    {
        echo '<p>-' . $p . '</p><br/>';
    }
    $i_question++;
}

