/*
 *
 * TABLES
 *
 */

-- Table Utilisateur
/* 
	Utilisateur basique, classe
	parent des élèves et professeurs
*/
CREATE TABLE Utilisateurs(
	IdUtilisateur INTEGER PRIMARY KEY AUTO_INCREMENT,
	Nom VARCHAR(64) NOT NULL,
	Prénom VARCHAR(64) NOT NULL,
	Login VARCHAR(64) UNIQUE NOT NULL,
	MotDePasse VARCHAR(128) NOT NULL
) ENGINE=InnoDB;

-- Table Elève
/*
	Classe enfant de l'utilisateur,
	vérifier à l'insertion que l'id
	fourni correspond bien à un Utilisateur
	existant
*/
CREATE TABLE Elèves(
	IdElève INTEGER PRIMARY KEY, -- Vérifier l'existence dans Utilisateur
	--NbQCMRéalisés INTEGER NOT NULL DEFAULT 0,
	--MoyenneQCM FLOAT NOT NULL DEFAULT 0, -- Mettre un trigger à l'insertion d'un résultat associé à l'élève
	CONSTRAINT fkElève_Utilisateur
		FOREIGN KEY(IdElève) REFERENCES Utilisateurs(IdUtilisateur)
) ENGINE=InnoDB;

-- Table Enseignant
/*
	Classe enfant de l'utilisateur,
	vérifier à l'insertion que l'id
	fourni correspond bien à un Utilisateur
	existant
*/
CREATE TABLE Enseignants(
	IdEnseignant INTEGER PRIMARY KEY,
	CONSTRAINT fkEnseignant_Utilisateur
		FOREIGN KEY(IdEnseignant) REFERENCES Utilisateurs(IdUtilisateur)
) ENGINE=InnoDB;

-- Table Thème
/**/
CREATE TABLE Thèmes(
	IdThème INTEGER PRIMARY KEY AUTO_INCREMENT,
	Description VARCHAR(500)
) ENGINE=InnoDB;

-- Table QCM
/**/
CREATE TABLE QCM(
	IdQCM INTEGER PRIMARY KEY AUTO_INCREMENT,
	LibelléQCM VARCHAR(128) NOT NULL,
	IdAuteur INTEGER NOT NULL,
	IdThème INTEGER NOT NULL,
	CONSTRAINT fkQCM_Auteur
		FOREIGN KEY(IdAuteur) REFERENCES Enseignants(IdEnseignant),
	CONSTRAINT fkQCM_Thème
		FOREIGN KEY(IdThème) REFERENCES Thèmes(IdThème)
);

-- Table Question
/**/
CREATE TABLE Questions(
	IdQuestion INTEGER PRIMARY KEY AUTO_INCREMENT,
	LibelléQuestion VARCHAR(256) NOT NULL,
	TempsQuestion INTEGER NOT NULL DEFAULT 60,
	IdQCMAssocié INTEGER NOT NULL,
	CONSTRAINT fkQuestion_QCM
		FOREIGN KEY(IdQCMAssocié) REFERENCES QCM(IdQCM)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- Table Proposition
/**/
CREATE TABLE Propositions(
	IdProposition INTEGER PRIMARY KEY AUTO_INCREMENT,
	LibelléProposition VARCHAR(256) NOT NULL,
	RésultatVraiFaux BOOLEAN NOT NULL,
	IdQuestionAssociée INTEGER NOT NULL,
	CONSTRAINT pkProposition_Question
		FOREIGN KEY(IdQuestionAssociée) REFERENCES Questions(IdQuestion)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- Table Résultats
/**/
CREATE TABLE Résultats(
	IdRésultat INTEGER PRIMARY KEY AUTO_INCREMENT,
	DateAffectation DATE,
	DateRéalisation DATE DEFAULT NULL,
	Note FLOAT DEFAULT NULL,
	-- Clé étrangère élève (Composition)
	IdElève INTEGER NOT NULL,
	CONSTRAINT fkRésultat_Elève
	FOREIGN KEY(IdElève) REFERENCES Elèves(IdElève)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	-- Clé étrangère QCM
	IdQCM INTEGER NOT NULL,
	FOREIGN KEY(IdQCM) REFERENCES QCM(IdQCM),
	-- Clé étrangère de l'enseignant ayant affecté le QCM
	IdResponsable INTEGER NOT NULL,
	FOREIGN KEY(IdResponsable) REFERENCES Enseignants(IdEnseignant)
);

CREATE TABLE Réponses(
	IdRésultat INTEGER NOT NULL,
	IdProposition INTEGER NOT NULL,
	-- RéponseElève FLOAT NOT NULL,
	PRIMARY KEY (IdRésultat, IdProposition),
	CONSTRAINT fkRéponse_Résultat
	FOREIGN KEY(IdRésultat) REFERENCES Résultats(IdRésultat)
);

/*
 *
 * TRIGGERS
 *
 */
 
-- calcul_moyenne
/*
	Doit calculer la nouvelle moyenne
	(inutile, moyenne et nbQcm de l'élève
	dynamiques)
*/
--CREATE TRIGGER calcul_moyenne
--ON Résultat
--AFTER INSERT, UPDATE, DELETE


-- check_résultat
/*
	Doit permettre de s'assurer q'un résultat inséré est
	valide (Note comprise entre 0 et 20, arrondie à 10^-2,
	date de réalisation supérieure à date d'affectation) 
*/