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
    public function create_résultat(Résultat $res): int
    {
        $date = $res->get_date_affectation();
        $id_e = $res->get_id_élève();
        $id_q = $res->get_id_qcm();
        $id_r = $res->get_id_responsable();
        
        // Vérification qu'il n'existe pas déjà une affectation de ce qcm à cet élève 
        $res = $this->get_qcm_élève_résultat($id_q, $id_e);
        if ($res != null) { return -1; }

        $statement = $this->db->prepare("INSERT INTO Résultats(DateAffectation, IdElève, IdQCM, IdResponsable) VALUES (:date, :élève, :qcm, :responsable);");
        $statement->bindParam(":date", $date, \PDO::PARAM_STR);
        $statement->bindParam(":élève", $id_e, \PDO::PARAM_INT);
        $statement->bindParam(":qcm", $id_q, \PDO::PARAM_INT);
        $statement->bindParam(":responsable", $id_r, \PDO::PARAM_INT);

        try {
            $statement->execute();
        } catch (\PDOException $e) {
            $_SESSION['erreur_sql']  = $statement->errorInfo()[2];
            return -1;
        }
        
        return (int)$this->db->lastInsertId();
    }


    /**
     * Get le résultat d'un QCM associé à un élève
     */
    public function get_qcm_élève_résultat(int $qcm, int $élève): ?Résultat
    {
        $statement = $this->db->prepare("SELECT * FROM Résultats WHERE IdElève = :id_e AND IdQCM = :id_q");
        $statement->bindParam(":id_e", $élève, \PDO::PARAM_INT);
        $statement->bindParam(":id_q", $qcm, \PDO::PARAM_INT);

        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);

        return ($arr != null) ? new Résultat(
            $arr['IdRésultat'],
            $arr['DateAffectation'],
            $arr['DateRéalisation'],
            $arr['Note'],
            $arr['IdElève'],
            $arr['IdQCM'],
            $arr['IdResponsable']
        ) : null;
    }
}