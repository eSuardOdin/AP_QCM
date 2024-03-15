<?php
declare(strict_types= 1);
namespace Qcm\Classes;

use \Qcm\Helpers\Database;
require_once("Classes/Helpers/Database.php");
use Qcm\Classes\Utilisateur;
require_once("Classes/Utilisateur.php");
class Qcm
{
    // Attributs
    private int $id_qcm;
    private string $libellé_qcm;
    private int $id_auteur;
    private int $id_thème;

    // Constructeur
    public function __construct(int $id_qcm, string $libellé_qcm, int $id_auteur, int $id_thème)
    {
        $this->id_qcm = $id_qcm;
        $this->libellé_qcm = $libellé_qcm;
        $this->id_auteur = $id_auteur;
        $this->id_thème = $id_thème;
    }

    // Getters
    public function get_id_qcm(): int { return $this->id_qcm; }
    public function get_libellé_qcm(): string { return $this->libellé_qcm; }
    public function get_id_auteur(): int { return $this->id_auteur; }
    public function get_id_thème(): int { return $this->id_thème; }

    // Setters
    public function set_id_qcm(int $id_auteur): void { $this->id_auteur = $id_auteur; }
    public function set_libellé_qcm(string $libellé_qcm): void { $this->libellé_qcm = $libellé_qcm; }
    public function set_id_auteur(int $id_auteur): void { $this->id_auteur = $id_auteur; }
    public function set_id_thème(int $id_thème): void { $this->id_thème = $id_thème; }

    // 
    private function compte_nb_question():int 
    {

        return 0;
    }

}