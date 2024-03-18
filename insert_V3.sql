INSERT INTO Utilisateurs(Nom, Prénom, Login, MotDePasse) VALUES ('Suard', 'Erwann', 'e.suard', '1234');
INSERT INTO Utilisateurs(Nom, Prénom, Login, MotDePasse) VALUES ('Kister', 'Olivier', 'o.kister', '1234');
INSERT INTO Utilisateurs(Nom, Prénom, Login, MotDePasse) VALUES ('Laassir', 'Smail', 's.laassir', '1234');
INSERT INTO Enseignants(IdEnseignant) VALUES (2);
INSERT INTO Elèves(IdElève) VALUES (1);


-- Thèmes
INSERT INTO Thèmes(Description) VALUES ("RESEAUX");
INSERT INTO Thèmes(Description) VALUES ("SYSTEME");


-- Premier QCM
INSERT INTO QCM(LibelléQCM, IdAuteur, IdThème) VALUES('Protocoles - 1', 2, 1);

INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES ('Quel protocole de communication ne nécessite pas de connexion préalable ?', 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('UDP', true, 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('TCP', false, 1);

INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES ('Quel protocole est utilisé par la commande ping ?', 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('ICMP', true, 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('FTP', false, 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('HTTP', false, 1);

INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES ('Quel protocole est utilisé pour le transfert de fichier ?', 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('ICMP', false, 3);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('FTP', true, 3);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('HTTP', false, 3);

INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES ('Que veut dire TCP ?', 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('True Control Packets', false, 4);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Transmission Control Protocol', false, 4);


-- Deuxième QCM
INSERT INTO QCM(LibelléQCM, IdAuteur, IdThème) VALUES('Systèmes (général) - 1', 2, 2);

INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES ('Un système d\'exploitation : ', 3);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Gère l\'assignation des ressources matérielles aux programmes en cours d\'execution', true, 5);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Fait l\'interface entre les applications et le materiel', true, 5);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Se brosse les dents tout seul', false, 5);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Fournit différents services', true, 5);


INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES ('Comment appelle t\'on un programme informatique qui s\'execute en arrière plan sans contrôle de l\'utilisateur (sous UNIX) ?', 3);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Un hamster sur roue', false, 5);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('Un daemon', true, 5);
