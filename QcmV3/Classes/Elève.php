<?php
declare(strict_types=1);
namespace Qcm\Classes;

use Qcm\Classes\Utilisateur;
/*
 *  
 * 
 */
class Elève extends Utilisateur
{
	// Attributs
	private int $nb_qcm_réalisés;
	private float $moyenne_qcm;

	// Constructeur
	public function __construct(
		int $id,
		string $nom,
		string $prénom,
		string $login,
		string $mdp,
		int $nb = 0,
		float $avg = 0
	)
	{
		parent::__construct($id, $nom, $prénom, $login, $mdp);
		$this->nb_qcm_réalisés = $nb;
		$this->moyenne_qcm = $avg;
	}

	// Getters
	public function get_nb_qcm_réalisés():int { return $this->nb_qcm_réalisés; }
	public function get_moyenne_qcm(): float  { return $this->moyenne_qcm; }

	// Setters
	public function set_nb_qcm_réalisés(int $nb) { $this->nb_qcm_réalisés = $nb; }
	public function set_moyenne_qcm(float $moy)  { $this->moyenne_qcm = $moy; }


	private function compte_nb_qcm_réalisés():int
	{
		/*
			Check la DB
		*/

		return 0;
	}


	private function calcul_moyenne_qcm(): float
	{
		/*
			Check la DB
		*/

		return 0;
	}
}