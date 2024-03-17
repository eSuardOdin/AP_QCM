<?php
declare(strict_types= 1);
namespace Qcm\Models;
use Qcm\Classes\Utilisateur;
include_once("Classes/Utilisateur.php");

session_start();


class UtilisateurModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }

    /**
     * Renvoie l'utilisateur'à l'ID spécifié ou null si not exists
     * @return Utilisateur
     */
    public function get_utilisateur(int $id): ?Utilisateur
    {
        $statement = $this->db->prepare("SELECT * FROM Utilisateurs WHERE IdUtilisateur = :id");
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        return new Utilisateur($id, $arr['Nom'], $arr['Prénom'], $arr['Login'], $arr['MotDePasse']);
    }
}