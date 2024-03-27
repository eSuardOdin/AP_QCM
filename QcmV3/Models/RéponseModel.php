<?php
declare(strict_types= 1);
namespace Qcm\Models;
session_start();

use Qcm\Classes\Réponse;
include_once("Classes/Réponse.php");

class RéponseModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }


    /**
     * Get toutes les réponses sur une assignation de QCM
     */
    public function get_réponses_from_résultat(int $id): ?array
    {
        $statement = $this->db->prepare("SELECT * FROM Réponses WHERE IdRésultat = :id;");
        $statement->bindParam(":id", $id, \PDO::PARAM_INT);
        $statement->execute();

        $res = [];
        $rows = $statement->fetch(\PDO::FETCH_ASSOC);

        if($rows == null) return null;

        foreach($rows as $row)
        {
            array_push(
                $res, 
                new Réponse($row['IdRésultat'], $row['IdProposition'])
            );
        }

        return $res;
    }

    public function save_réponse(Réponse $r)
    {
        $statement = $this->db->prepare("INSERT INTO Réponses(IdRésultat, IdProposition) VALUE (:id_r, id_p);");
        $statement->bindValue(":id_r", $r->get_id_résultat(), \PDO::PARAM_INT);
        $statement->bindValue(":id_p", $r->get_id_proposition(), \PDO::PARAM_INT);

        try
        {
            $statement->execute();
        }
        catch(\PDOException $e)
        {
            $_SESSION['erreur_sql']  = $statement->errorInfo()[2];
            return -1;
        }

        return $this->db->lastInsertId();
    }
}