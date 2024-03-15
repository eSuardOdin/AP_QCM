<?php
declare(strict_types=1);
namespace Qcm\Classes;

/*
 * Utilisateur classique, classe mère des élèves et professeur 
 * 
 */
class Utilisateur
{
	// Attributs
	protected int $id_utilisateur;
	protected string $nom;
	protected string $prénom;
	protected string $login;
	protected string $mot_de_passe;

	// Constructeur
	public function __construct(
		int $id,
		string $nom,
		string $prénom,
		string $login,
		string $mdp
	)
	{
		$this->get_id_utilisateur	= $id;
		$this->nom 					= $nom;
		$this->prénom 				= $prénom;
		$this->login 				= $login;
		$this->mot_de_passe 		= $mdp;
	}

	// Getters
	public function get_id_utilisateur():int 	{ return $this->id_utilisateur; }
	public function get_nom():string 			{ return $this->nom; }
	public function get_prénom():string 		{ return $this->prénom; }
	public function get_login():string 			{ return $this->login; }
	public function get_mot_de_passe():string	{ return $this->mot_de_passe; }

	// Setters
	public function set_nom(string $nom)			{ $this->nom = $nom; }
	public function set_prénom(string $prénom)		{ $this->prénom = $prénom; }
	public function set_login(string $login)		{ $this->login = $login; }
	public function set_mot_de_passe(string $mdp)	{ $this->mot_de_passe = $mdp; }

}