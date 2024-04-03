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

echo '
<html>
<body>
<p>Pour ajouter un QCM, il faut au moins une proposition juste par question</p>
<form name="qcm_form" method="post" action="router.php">
    <label for="libellé">Titre du QCM : </label>
    <input type="text" name="libellé" minlength="2" maxlength="128" required>
    <br/><br/><label for="old_thème">Thème : </label>
    <select name="old_thème" id="old_thème">';

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
    <br/><br/>
    <div id="questions_container">
    </div>
    <button type="button" id="add_question">Ajouter une question</button>
    <input type="submit" name="page" value="Créer QCM"/>
</form> ';
?>



<script>
document.addEventListener("DOMContentLoaded", function() {
    var questionCount = 0;

    function addQuestion() {
        questionCount++;
        var questionContainer = document.getElementById('questions_container');

        var questionDiv = document.createElement('div');
        questionDiv.className = 'question';
        questionDiv.style.margin = "8px";

        var questionLabel = document.createElement('label');
        questionLabel.setAttribute('for', 'question_' + questionCount);
        questionLabel.textContent = 'Question ' + questionCount + ':';
        questionLabel.style.textDecoration = "underline";
        
        
        var questionInput = document.createElement('input');
        questionInput.type = 'text';
        questionInput.minLength = '8';
        questionInput.maxLength = '256';
        questionInput.name = 'questions[]';
        questionInput.id = 'question_' + questionCount;
        questionInput.required = true;
        questionInput.appendChild(document.createElement('br'));

        var addPropositionButton = document.createElement('button');
        addPropositionButton.type = 'button';
        addPropositionButton.textContent = 'Ajouter une proposition';
        addPropositionButton.className = 'add_proposition';
        addPropositionButton.addEventListener('click', function() {
            addProposition(this);
        });

        var propositionsContainer = document.createElement('div');
        propositionsContainer.className = 'propositions_container';

        questionDiv.appendChild(questionLabel);
        questionDiv.appendChild(questionInput);
        questionDiv.appendChild(addPropositionButton);
        questionDiv.appendChild(propositionsContainer);

        questionContainer.appendChild(questionDiv);
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

    // Ajout d'une proposition
    function addProposition(button) {
        var propositionCount = button.parentElement.querySelectorAll('.proposition').length + 1;

        var propositionDiv = document.createElement('div');
        propositionDiv.className = 'proposition';

        var propositionInput = document.createElement('input');
        propositionInput.type = 'text';
        propositionInput.minLength = '1';
        propositionInput.maxLength = '256';
        propositionInput.name = 'propositions[' + questionCount + '][]';
        propositionInput.required = true;

        var propositionCheckbox = document.createElement('input');
        propositionCheckbox.type = 'checkbox';
        propositionCheckbox.name = 'reponses[' + questionCount + '][]';
        propositionCheckbox.id = 'reponse_' + questionCount + '_' + propositionCount;

        var propositionLabel = document.createElement('label');
        propositionLabel.setAttribute('for', 'reponse_' + questionCount + '_' + propositionCount);
        propositionLabel.textContent = 'Réponse Correcte';

        propositionDiv.appendChild(propositionInput);
        propositionDiv.appendChild(propositionCheckbox);
        propositionDiv.appendChild(propositionLabel);

        button.parentElement.querySelector('.propositions_container').appendChild(propositionDiv);
    }

    document.getElementById('add_question').addEventListener('click', function() {
        addQuestion();
    });

    document.getElementById('switch_thème').addEventListener('click', function() {
        switchThèmes();
    });

    // Ajouter une question par défaut au chargement de la page
    addQuestion();
});
</script>

</body>
</html>

