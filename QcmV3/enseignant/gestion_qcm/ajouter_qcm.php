<html>
<body>
<p>Pour ajouter un QCM, il faut au moins une proposition juste par question</p>
<p>PENSER A RAJOUTER LES THEMES</p>
<form id="qcm_form" method="post" action="traitement.php">
    <input type="text" name="libellé">
    <div id="questions_container">
        <!-- Les questions ajoutées dynamiquement seront placées ici -->
    </div>
    <button type="button" id="add_question">Ajouter une question</button>
    <button name="page" type="submit">Créer QCM</button>
</form>
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

    function addProposition(button) {
        var propositionCount = button.parentElement.querySelectorAll('.proposition').length + 1;

        var propositionDiv = document.createElement('div');
        propositionDiv.className = 'proposition';

        var propositionInput = document.createElement('input');
        propositionInput.type = 'text';
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

    // Ajouter une question par défaut au chargement de la page
    addQuestion();
});
</script>

</body>
</html>

<?php
session_start();
use Qcm\Models\QcmModel;
include_once("Models/QcmModel.php");
use Qcm\Models\QuestionModel;
include_once("Models/QuestionModel.php");
use Qcm\Models\PropositionModel;
include_once("Models/PropositionModel.php");