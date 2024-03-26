<?php
declare(strict_types= 1);
namespace Qcm\Models;
session_start();

use Qcm\Classes\Résultat;
include_once("Classes/Résultat.php");

class RésultatModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }
    
    /**
     * Entrée originale du résultat (aka affectation) dans la db
     */
    public function create_résultat($dateAffectation, $id_e, $id_q, $id_r): int
    {        
        // Vérification qu'il n'existe pas déjà une affectation de ce qcm à cet élève 
        $res = $this->get_qcm_élève_résultat($id_q, $id_e);
        if ($res != null) { return -1; }
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        // Je n'arrive pas à utiliser les placeholders pour cette requète, à cause de NULL ?
        /*
        $statement = $this->db->prepare("INSERT INTO Résultats(DateAffectation, DateRéalisation, Note, IdElève, IdQCM, IdResponsable) 
        VALUES (:DateAffectation, :DateRéalisation, :Note, :Elève, :Qcm, :Responsable);");
        $statement->bindParam(":DateAffectation", $dateAffectation, \PDO::PARAM_STR);
        $statement->bindValue(":DateRéalisation", null, \PDO::PARAM_STR);
        $statement->bindValue(":Note", null, \PDO::PARAM_STR);
        $statement->bindParam(":Elève", $id_e, \PDO::PARAM_INT);
        $statement->bindParam(":Qcm", $id_q, \PDO::PARAM_INT);
        $statement->bindParam(":Responsable", $id_r, \PDO::PARAM_INT);
        */

        // Je l'écris donc en dur même si non secure, mon form n'est pas censé permettre d'injection.. (pas de champ d'input text)
        $statement = $this->db->prepare("INSERT INTO Résultats(DateAffectation, DateRéalisation, Note, IdElève, IdQCM, IdResponsable) 
        VALUES ('".$dateAffectation."', NULL, NULL, ". $id_e. ", ". (int)$id_q .", " . $id_r .");");
        try {
            $statement->execute();
        } catch (\PDOException $e) {
            $_SESSION['erreur_sql']  = $e;
            $statement->debugDumpParams();

            // Récupération de la requête SQL complète
            ob_start();
            $statement->debugDumpParams();
            $dump = ob_get_clean();
            $sql = strstr($dump, '# 0', true);
            $_SESSION['requete']  = $sql;
            // $_SESSION['erreur_sql']  = $statement->errorInfo()[2];
            return -2;
        }
        
        return (int)$this->db->lastInsertId();
    }


    /**
     * Get le résultat d'un QCM associé à un élève
     */
    public function get_qcm_élève_résultat(int $qcm, int $élève): ?int
    {
        $statement = $this->db->prepare("SELECT * FROM Résultats WHERE IdElève = :id_e AND IdQCM = :id_q");
        $statement->bindParam(":id_e", $élève, \PDO::PARAM_INT);
        $statement->bindParam(":id_q", $qcm, \PDO::PARAM_INT);

        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);

        return $arr['IdRésultat'];
    }

    /**
     * Obtenir tous les résultats/affectations d'un élève
     * @return Résultat[]
     */
    public function get_all_résultat_élève(int $id_élève): array
    {
        $statement = $this->db->prepare('SELECT * FROM Résultats WHERE IdElève = :id');
        $statement->bindParam(':id', $id_élève, \PDO::PARAM_INT);
        $statement->execute();

        $_SESSION['query'] = $statement;
        $res = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row)
        {
            array_push(
                $res, 
                new Résultat(
                    $row['IdRésultat'],
                    $row['DateAffectation'],
                    $row['DateRéalisation'],
                    $row['Note'],
                    $row['IdElève'],
                    $row['IdQCM'],
                    $row['IdResponsable']
                )
            );
        }
        return $res;
    }
}