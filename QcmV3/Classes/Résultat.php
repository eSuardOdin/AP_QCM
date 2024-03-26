<?php
declare(strict_types= 1);
namespace Qcm\Classes;

class Résultat
{
    // Attributs
    private int $id_résultat;
    private string $date_affectation;
    private ?string $date_réalisation;
    private ?int $note;
    private int $id_élève;
    private int $id_qcm;
    private int $id_responsable;

    // Constructeur
    public function __construct(int $id, string $date_aff, ?string $date_réal, ?int $note, int $élève, int $qcm, int $resp)
    {
        $this->id_résultat = $id;
        $this->date_affectation = $date_aff;
        $this->date_réalisation = $date_réal;
        $this->note = $note;
        $this->id_élève = $élève;
        $this->id_qcm = $qcm;
        $this->id_responsable = $resp;
    }

    // Getters
    public function get_id_résultat(): int { return $this->id_résultat; }
    public function get_date_affectation(): string { return $this->date_affectation; }
    public function get_date_réalisation(): ?string { return $this->date_réalisation; }
    public function get_note(): ?int { return $this->note; }
    public function get_id_élève(): int { return $this->id_élève; }
    public function get_id_qcm(): int { return $this->id_qcm; }
    public function get_id_responsable(): int { return $this->id_responsable; }

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
    public function set_note(int $note): void
    {
        $this->note = $note;
    }
    public function set_id_élève(int $id): void
    {
        $this->id_élève = $id;
    }public function set_id_qcm(int $id): void
    {
        $this->id_qcm = $id;
    }public function set_id_responsable(int $id): void
    {
        $this->id_responsable = $id;
    }
}