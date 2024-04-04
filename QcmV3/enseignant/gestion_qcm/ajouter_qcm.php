<html>
<body>
<?php
session_start();
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");
use Qcm\Models\ThèmeModel;
include_once("Models/ThèmeModel.php");

// Traitement du qcm ajouté (db etc)
if(isset($_SESSION['qcm_form']['terminé']) && $_SESSION['qcm_form']['terminé'])
{

}
// Traitement d'une question
else if(isset($_SESSION['qcm_form']['terminé']) && !$_SESSION['qcm_form']['terminé'])
{
    echo '
    <form name="question_form" method="post" action="router.php">
    <label for="libellé_question">Question : </label>
    <input type="text" name="libellé_question" minlength="8" maxlength="256" required/>

    <div id="reponses">
        <div>
            <p>Proposition n°1</p>
            <input type="text" name="reponse[]" required placeholde="Réponse"/>
            <input type="checkbox" name=correcte[0] value="1"/> -> Réponse correcte
        </div>
    </div>
    <button type="button" id="add_rep">Ajouter réponse</button>

    </br>

    <input type="submit" name="page" value="Ajouter une question"/>
    <input type="submit" name="page" value="Valider le QCM"/>
    <input type="submit" name="page" value="Annuler la création"/>
    ';
}
// Traitement du titre et thème du qcm
else
{
    echo '
    <form name="qcm_form" method="post" action="router.php">
    <label for="libellé">Titre du QCM : </label>
    <input type="text" name="libellé" minlength="2" maxlength="128" required>
    <br/><br/><label for="old_thème">Thème : </label>
    <select name="old_thème" id="old_thème">
    ';

    // Thème
    $thème_model = new ThèmeModel();
    $thèmes = $thème_model->get_all_thèmes();
    foreach($thèmes as $t)
    {
        echo'<option value="' . $t->get_id_thème() . '">' . $t->get_description() . '</option>';
    }

    echo '
    </select>
    <input type="text" name="new_thème" id="new_thème" minlenght="2" maxlenght="500" disabled style="visibility:hidden"/>
    <br/><button type="button" class="active_btn" id="switch_thème">Créer thème</button>
    <br/><br/>';

    echo '
        <input type="submit" name="page" value="Valider et ajouter des questions"/>
        <input type="submit" name="page" value="Annuler la création"/>
    ';
        
}


?>



<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pour l'ajout de proposition par question, on réinit à chaque chargement de page
    var compteurReponses = 1;

    function addReponse()
    {
        var repContainer = document.getElementById('reponses');
        var newRep = document.createElement('div');
        newRep.innerHTML = '<p>Proposition n°' + (compteurReponses+1) + '</p><input type="text" name="reponse[]" required placeholde="Réponse"/><input type="checkbox" name=correcte[' + compteurReponses + '] value="1"/> -> Réponse correcte';
        repContainer.appendChild(newRep);
        ++compteurReponses;
    }
    // Switch choix / création de thème
    function switchThèmes()
    {
        var switchBtn = document.getElementById('switch_thème');
        var oldT = document.getElementById('old_thème');
        var newT = document.getElementById('new_thème');
        if(switchBtn.className == "active_btn")
        {
            switchBtn.className = "inactive_btn";
            oldT.setAttribute('disabled', 'disabled');
            oldT.setAttribute('style', 'visibility: hidden;');
            newT.removeAttribute('disabled');
            newT.setAttribute('style', 'visibility: visible;');
        }
        else
        {
            switchBtn.className = "active_btn";
            newT.setAttribute('disabled', 'disabled');
            newT.setAttribute('style', 'visibility: hidden;');
            newT.value = "";
            oldT.removeAttribute('disabled');
            oldT.setAttribute('style', 'visibility: visible;');
        }
        // switchBtn.className = (switchBtn.className == "inactive_btn") ? "active_btn" : "inactive_btn";

    }
    
    if(document.getElementById('add_rep') != null)
    {
        document.getElementById('add_rep').addEventListener('click', function() {
            addReponse();
        });
    }
    if(document.getElementById('switch_thème') != null)
    {
        document.getElementById('switch_thème').addEventListener('click', function() {
            switchThèmes();
        });
    }

    
});
</script>

</body>
</html>

