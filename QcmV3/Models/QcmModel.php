<?php
declare(strict_types= 1);
namespace Qcm\Models;
session_start();

use Qcm\Classes\Qcm;
include_once("Classes/Qcm.php");


class QcmModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }

    /**
     * Renvoie le QCM à l'ID spécifié ou null si not exists
     * @return Qcm
     */
    public function get_qcm(int $id): ?Qcm
    {
        $statement = $this->db->prepare("SELECT * FROM QCM WHERE IdQCM = :id");
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        return new Qcm($id, $arr['LibelléQCM'], $arr['IdAuteur'], $arr['IdThème']);
    }

    /**
     * Récupère tous les QCM de la db et les renvoie dans une array
     * @return Qcm[]
     */
    public function get_all_qcm(): array
    {
        $statement = $this->db->prepare("SELECT * FROM QCM");
        $statement->execute();
        $res = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $qcm)
        { 
            array_push($res, new Qcm((int)$qcm['IdQCM'], $qcm['LibelléQCM'], $qcm['IdAuteur'], $qcm['IdThème']));
        }
        return $res;
    }

    public function delete_qcm(int $id)
    {
        $statement = $this->db->prepare('DELETE FROM QCM WHERE IdQCM = :id;');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        
    }
}