<?php
declare(strict_types=1);
namespace Qcm\Classes;

use Qcm\Classes\Utilisateur;
/*
 *
 */
class Enseignant extends Utilisateur
{
	// Attributs
	private int $nb_qcm_créés;

	// Constructeur
	public function __construct(
		int $id,
		string $nom,
		string $prénom,
		string $login,
		string $mdp,
		int $nb,
		float $avg
	)
	{
		parent::__construct($id, $nom, $prénom, $login, $mdp);
		$this->nb_qcm_créés = $nb;
	}

	// Getters
	public function get_nb_qcm_créés():int { return $this->nb_qcm_créés; }

	// Setters
	public function set_nb_qcm_créés(int $nb_qcm)
	{
		$this->nb_qcm_créés = $nb_qcm;
	}


	// Autres méthodes
	private function compte_nb_qcm_créés():int
	{

		return 0;
	}

}