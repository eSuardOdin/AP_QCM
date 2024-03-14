INSERT INTO Utilisateurs(Nom, Prénom, Login, MotDePasse) VALUES ('Suard', 'Erwann', 'e.suard', '1234');
INSERT INTO Utilisateurs(Nom, Prénom, Login, MotDePasse) VALUES ('Kister', 'Olivier', 'o.kister', '1234');
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
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('ICMP', false, 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('FTP', true, 1);
INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES ('HTTP', false, 1);
