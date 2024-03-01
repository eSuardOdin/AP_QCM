<?php
declare(strict_types=1);
namespace Qcm\Classes;

class Proposition
{
    // Attributs
    private int $id_proposition;
    private string $libellé_proposition;
    private bool $résultat_vrai_faux;

    // Constructeur
    public function __construct(int $id_proposition, string $libellé_proposition, bool $résultat_vrai_faux)
    {
        $this->id_proposition = $id_proposition;
        $this->libellé_proposition = $libellé_proposition;
        $this->résultat_vrai_faux = $résultat_vrai_faux;
    }

    // Getters
    public function get_id_proposition(): int { return $this->id_proposition; }
    public function get_libellé_proposition(): string { return $this->libellé_proposition; }
    public function get_résultat_vrai_faux(): bool { return $this->résultat_vrai_faux; }

    // Setters
    public function set_id_proposition(int $id)
    {
        $this->id_proposition = $id;
    }
    public function set_libellé_proposition(string $libellé)
    {
        $this->libellé_proposition = $libellé;
    }
    public function set_résultat_vrai_faux(bool $is_vrai)
    {
        $this->résultat_vrai_faux = $is_vrai;
    }
}