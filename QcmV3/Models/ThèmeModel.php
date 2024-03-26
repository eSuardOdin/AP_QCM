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
}