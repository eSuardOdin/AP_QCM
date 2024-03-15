<?php
declare(strict_types= 1);
namespace Qcm\Classes;

class Résultat
{
    // Attributs
    private int $id_résultat;
    private string $date_affectation;
    private string $date_réalisation;
    private int $note;

    // Constructeur
    public function __construct(int $id, string $date_aff, string $date_réal, int $note)
    {
        $this->id_résultat = $id;
        $this->date_affectation = $date_aff;
        $this->date_réalisation = $date_réal;
        $this->note = $note;
    }

    // Getters
    public function get_id_résultat(): int { return $this->id_résultat; }
    public function get_date_affectation(): string { return $this->date_affectation; }
    public function get_date_réalisation(): string { return $this->date_réalisation; }
    public function get_note(): int { return $this->note; }

    // Setters
    public function set_id_résultat(int $id_résultat): void
    {
        $this->id_résultat = $id_résultat;
    }
    public function set_date_affectation(string $date_affectation): void
    {
        $this->date_affectation = $date_affectation;
    }
    public function set_date_réalisation(string $date_réalisation): void
    {
        $this->date_réalisation = $date_réalisation;
    }
}