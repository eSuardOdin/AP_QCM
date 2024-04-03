<?php
declare(strict_types= 1);
namespace Qcm\Models;
session_start();

use Qcm\Classes\Thème;
include_once("Classes/Thème.php");

class ThèmeModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }
    
    /**
     * Get un thème par son ID
     */
    public function get_thème($id): ?Thème
    {
        $statement = $this->db->prepare('SELECT * FROM Thèmes WHERE IdThème = :id');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $res = null;
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($result != null)
        {
            $res = new Thème($result['IdThème'], $result['Description']);
        }

        return $res;
    }

    /**
     * Get tous les thèmes et return une array d'objets Thème
     */
    public function get_all_thèmes(): array
    {
        $arr = [];

        $statement = $this->db->prepare('SELECT * FROM Thèmes;');
        try
        {
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            foreach($result as $t)
            {

                array_push($arr, new Thème($t['IdThème'], $t['Description']));
            }
        }
        catch(\PDOException $e)
        {
            $_SESSION['erreur_sql'] = $e->getMessage();
        }

        return $arr;
    }


    /**
     * Ajouter un thème dans la db
     */
    public function save_thème(string $description): int
    {
        $statement = $this->db->prepare('INSERT INTO Thèmes(Description) VALUES (:descript);');
        $statement->bindParam(':descript', $description, \PDO::PARAM_STR);
        try
        {
            $statement->execute();
            return (int)$this->db->lastInsertId();
        }
        catch(\PDOException $e)
        {
            $_SESSION['erreur_sql'] = $e->getMessage();
        }
        return -1;
    }
}