<?php
declare(strict_types= 1);
namespace Qcm\Classes;

class Réponse
{
    // Attributs
    private float $réponse_élève;

    // Constructeur
    public function __construct(float $réponse_élève)
    {
        $this->réponse_élève = $réponse_élève;
    }

    // Getters
    public function get_réponse_élève(): float { return $this->réponse_élève; }

    // Setters
    public function set_réponse_élève($reponse): void
    {
        $this->réponse_élève = $reponse;
    }
}