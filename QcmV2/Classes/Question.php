<?php
declare(strict_types=1);
namespace Qcm\Classes;

class Question
{
    // Attributs
    private int $id_question;
    private string $libellé_question;
    private int $temps_question;

    // Constructeur
    public function __construct(int $id_question, $libellé_question, $temps_question)
    {
        $this->id_question = $id_question;
        $this->libellé_question = $libellé_question;
        $this->temps_question = $temps_question;
    }

    // Getters
    public function get_id_question(): int { return $this->id_question; }
    public function get_libellé_question(): string { return $this->libellé_question; }
    public function get_temps_question(): int { return $this->temps_question; }

    // Setters
    public function set_id_question(int $id_question): void { $this->id_question = $id_question; }
    public function set_libellé_question(string $libellé_question): void { $this->libellé_question = $libellé_question;}
    public function set_temps_question(int $temps_question): void { $this->temps_question = $temps_question; } // Pas raccord avec l'UML, à vérifier.

    // Autres méthodes
    private function calcul_points_question(): float
    {

        return 0;
    }

}