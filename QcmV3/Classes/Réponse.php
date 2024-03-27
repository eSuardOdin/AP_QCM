<?php
declare(strict_types= 1);
namespace Qcm\Classes;

class Réponse
{
    // Attributs
    private int $id_résultat;
    private int $id_proposition;
    // private float $réponse_élève;

    // Constructeur
    public function __construct(int $id_résultat, int $id_proposition/*, float $réponse_élève*/)
    {
        $this->id_résultat = $id_résultat;
        $this->id_proposition = $id_proposition;
        // $this->réponse_élève = $réponse_élève;
    }

    // Getters
    // public function get_réponse_élève(): float { return $this->réponse_élève; }
    public function get_id_résultat(): int { return $this->id_résultat; }
    public function get_id_proposition(): int { return $this->id_proposition; }

    // Setters
    // public function set_réponse_élève($reponse): void
    // {
    //     $this->réponse_élève = $reponse;
    // }

    public function set_id_résultat($id): void
    {
        $this->id_résultat = $id;
    }

    public function set_id_proposition($id): void
    {
        $this->id_proposition = $id;
    }
}