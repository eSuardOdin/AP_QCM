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
        
        try
        {
            $statement->execute();
    
            $res = [];
            $rows = $statement->fetchALL(\PDO::FETCH_ASSOC);
    
            // Débug
            error_log("*******************************************");
            
            if($rows == null) return null;
    
            foreach($rows as $row)
            {
                error_log("IdRésultat : " . $id . " | IdProposition : " . $row['IdProposition'],0);
                array_push(
                    $res, 
                    new Réponse($id, $row['IdProposition'])
                );
            }
            error_log("*******************************************");
            
            return $res;
        }
        catch(\PDOException $e)
        {
            error_log("*******************************************");
            error_log($e->getMessage(),0);
            error_log("*******************************************");

            // $_SESSION['erreur_sql'] = $e->getMessage();
            return null;
        }
    }

    public function save_réponse($id_r, $id_p)
    {
        $statement = $this->db->prepare("INSERT INTO Réponses(IdRésultat, IdProposition) VALUE (:id_r, :id_p);");
        $statement->bindValue(":id_r", $id_r, \PDO::PARAM_INT);
        $statement->bindValue(":id_p", $id_p, \PDO::PARAM_INT);

        try
        {
            $statement->execute();
        }
        catch(\PDOException $e)
        {
            $_SESSION['erreur_sql']  = $e->getMessage();
            return -1;
        }

        return $this->db->lastInsertId();
    }
}