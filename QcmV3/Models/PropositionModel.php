<?php
declare(strict_types= 1);
namespace Qcm\Models;
session_start();

use Qcm\Classes\Proposition;
include_once("Classes/Proposition.php");

class PropositionModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }

    /**
     * Get une proposition par son Id
     * @return ?Proposition
     */
    public function get_Proposition(int $id): ?Proposition
    {
        $statement = $this->db->prepare("SELECT * FROM Propositions WHERE IdProposition = :id;");
        $statement->bindParam(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($arr != null)
        {
            return new Proposition($arr['IdProposition'], $arr['LibelléProposition'], ($arr['RésultatVraiFaux'] == 1), $arr['IdQuestionAssociée']);
        }
    }


    /**
     * Return les Propositions associées à une question
     * @return Proposition[]
     */
    public function get_question_propositions(int $question_id): array
    {
        $statement = $this->db->prepare('SELECT * FROM Propositions WHERE IdQuestionAssociée = :id;');
        $statement->bindParam(":id", $question_id, \PDO::PARAM_INT);
        $statement->execute();

        $res = [];

        foreach($statement->fetchAll(\PDO::FETCH_ASSOC) as $arr)
        {
            array_push($res, new Proposition($arr['IdProposition'], $arr['LibelléProposition'], ($arr['RésultatVraiFaux'] == 1), $arr['IdQuestionAssociée']));
        }
        return $res;
    }

    /**
     * Return les bonnes Propositions associées à une question
     * @return Proposition[]
     */
    public function get_question_propositions_justes(int $question_id): array
    {
        $statement = $this->db->prepare('SELECT * FROM Propositions WHERE IdQuestionAssociée = :id AND RésultatVraiFaux = TRUE;');
        $statement->bindParam(":id", $question_id, \PDO::PARAM_INT);
        $statement->execute();

        $res = [];

        foreach($statement->fetchAll(\PDO::FETCH_ASSOC) as $arr)
        {
            array_push($res, new Proposition($arr['IdProposition'], $arr['LibelléProposition'], ($arr['RésultatVraiFaux'] == 1), $arr['IdQuestionAssociée']));
        }
        return $res;
    }


    public function add_proposition($lib, $is_t, $id_q): int
    {
        // $statement = $this->db->prepare("INSERT INTO QCM(LibelléQCM, IdAuteur, IdThème) VALUES ('".$lib."',".$id_a.", ".$id_t.");");
        $statement = $this->db->prepare("INSERT INTO Propositions(LibelléProposition, RésultatVraiFaux, IdQuestionAssociée) VALUES (:lib, :is_t, :id_q);");
        $statement->bindParam(":lib", $lib, \PDO::PARAM_STR);
        $statement->bindParam(":is_t", $is_t, \PDO::PARAM_BOOL);
        $statement->bindParam(":id_q", $id_q, \PDO::PARAM_INT);

        try
        {
            $statement->execute();
            return (int)$this->db->lastInsertId();
        }
        catch(\PDOException $e)
        {
            $_SESSION['erreur_sql'] = $e->getMessage();
            return -1;
        }
    }
}