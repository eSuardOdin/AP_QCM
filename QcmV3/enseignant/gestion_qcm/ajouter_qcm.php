<html>
<body>
<?php
session_start();

use Qcm\Classes\Qcm;
include_once("Classes/Qcm.php");
use Qcm\Classes\Question;
include_once("Classes/Question.php");
use Qcm\Classes\Proposition;
include_once("Classes/Proposition.php");
use Qcm\Classes\Thème;
include_once("Classes/Thème.php");

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
    // Instance des models
    $qcm_model = new QcmModel();
    $question_model = new QuestionModel();
    $prop_model = new PropositionModel();
    $thème_model = new ThèmeModel();


    $id_thème = -1;
    // Si nouveau Thème, ajout du thème à la db
    if(!$_SESSION['qcm_form']['thème']['existe'])
    {
        $id_thème = $thème_model->save_thème($_SESSION['qcm_form']['thème']['titre']);
    }
    else
    {
        $id_thème = (int)$_SESSION['qcm_form']['thème']['titre'];
    }

    // Si thème en erreur
    if($id_thème == -1)
    {
        echo '<p>Erreur, thème inconnu</p>';
    }
    else
    {
        $thème = $thème_model->get_thème($id_thème);
        // Ajout du qcm et get son ID
        $qcm_id = $qcm_model->add_qcm($_SESSION['qcm_form']['titre'], (int)$_SESSION['user']['IdUtilisateur'], $id_thème);

        // Ajout des questions
        foreach($_SESSION['qcm_form']['questions'] as $q)
        {
            $id_question = $question_model->add_question($q['question'], $qcm_id);
            foreach ($q['réponses'] as $r)
            {
                $prop_model->add_proposition($r[0], $r[1], $id_question);
            }
        }
    }
    
    echo 'Je n\'ai pas du tout assez travaillé la validation mais on va dire que ce QCM est bien enregistré';
    $_SESSION['qcm_form'] = null;
}




// Traitement d'une question
else if(isset($_SESSION['qcm_form']['terminé']) && !$_SESSION['qcm_form']['terminé'])
{
    echo $_SESSION['qcm_form']['erreur'] . '
    <form name="question_form" method="post" action="router.php">
    <label for="libellé_question">Question : </label>
    <input type="text" name="libellé_question" minlength="8" maxlength="256" required/>

    <div id="reponses">
        <div>
            <p>Proposition n°1</p>
            <input type="text" name="reponse[]" required placeholde="Réponse"/>
            Réponse correcte: <input type="checkbox" name=correcte[0] value="1"/>
        </div>
    </div>
    <button type="button" id="add_rep">Ajouter réponse</button>

    </br>

    <input type="submit" name="page" value="Ajouter une question"/>
    <input type="submit" name="page" value="Valider le QCM"/>
    </form>

    <form method="post" action="router.php">
    <input type="submit" name="page" value="Annuler la création"/>
    </form>
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
        </form>
        
        <form method="post" action="router.php">
        <input type="submit" name="page" value="Annuler la création"/>
        </form>
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
        newRep.innerHTML = '<p>Proposition n°' + (compteurReponses+1) + '</p><input type="text" name="reponse[]" required placeholde="Réponse"/>Réponse correcte: <input type="checkbox" name=correcte[' + compteurReponses + '] value="1"/>';
        repContainer.appendChild(newRep);
        ++compteurReponses;
        if(compteurReponses == 5)
        {
            (document.getElementById('add_rep')).setAttribute('disabled', 'disabled');
        }
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

