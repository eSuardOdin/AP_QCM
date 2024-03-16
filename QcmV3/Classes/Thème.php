<?php
declare(strict_types=1);
namespace Qcm\Classes;

class Thème
{
    // Attributs
    private int $id_thème;
    private string $description;

    // Constructeur
    public function __construct($id_thème, $description)
    {
        $this->id_thème = $id_thème;
        $this->description = $description;
    }


    // Getters
    public function get_id_thème(): int  { return $this->id_thème; }
    public function get_description(): string  { return $this->description; }

    // Setters
    public function set_id_thème(int $id)
    {
        $this->id_thème = $id;
    }
    public function set_description(string $description)
    {
        $this->description = $description;
    }
}