<?php
declare(strict_types= 1);
namespace Qcm\Models;
session_start();

use Qcm\Classes\Question;
include_once("Classes/Question.php");

class QuestionModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }

    /**
     * Get une question par son Id
     * @return ?Question
     */
    public function get_question(int $id): ?Question
    {
        $statement = $this->db->prepare("SELECT * FROM Questions WHERE IdQuestion = :id;");
        $statement->bindParam(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($arr != null)
        {
            return new Question($arr['IdQuestion'], $arr['LibelléQuestion'], $arr['TempsQuestion'], $arr['IdQCMAssocié']);
        }
    }


    /**
     * Return les questions associées à un qcm
     * @return Question[]
     */
    public function get_qcm_questions(int $qcm_id): array
    {
        $statement = $this->db->prepare('SELECT * FROM Questions WHERE IdQCMAssocié = :id;');
        $statement->bindParam(":id", $qcm_id, \PDO::PARAM_INT);
        $statement->execute();

        $res = [];

        foreach($statement->fetchAll(\PDO::FETCH_ASSOC) as $arr)
        {
            array_push($res, new Question($arr['IdQuestion'], $arr['LibelléQuestion'], $arr['TempsQuestion'], $arr['IdQCMAssocié']));
        }
        return $res;
    }

    public function add_question($lib, $id_q): int
    {
        // $statement = $this->db->prepare("INSERT INTO QCM(LibelléQCM, IdAuteur, IdThème) VALUES ('".$lib."',".$id_a.", ".$id_t.");");
        $statement = $this->db->prepare("INSERT INTO Questions(LibelléQuestion, IdQCMAssocié) VALUES (:lib, :id_q);");
        $statement->bindParam(":lib", $lib, \PDO::PARAM_STR);
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