<?php
declare(strict_types= 1);
namespace Qcm\Helpers;

use Qcm\Classes\Qcm;
include_once("Classes/Qcm.php");
use Qcm\Classes\Utilisateur;
class Database
{
    // Attributs
    private string $server;
    private string $username;
    private string $password;
    private string $database;
    private \PDO $db;

    // Constructeur
    public function __construct(
        string $server,
        string $username,
        string $password,
        string $database
    )
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->db = new \PDO("mysql:host=$this->server;dbname=$this->database;charset=utf8",$username,$password);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /* Utilisateur */
    /**
     * Ajoute un utilisateur à la base de données
     * et renvoie son ID
     */
    public function add_utilisateur(
        string $nom,
        string $prénom,
        string $login,
        string $mdp
    ): int
    {
        session_start();
        $statement = $this->db->prepare("INSERT INTO Utilisateurs(Nom, Prénom, Login, MotDePasse) VALUES (? , ? , ? , ?);");
        try {
            $statement->execute([$nom, $prénom, $login, $mdp]); // Pareil que bind param mais avec "?"
        } catch (\PDOException $e) {
            $_SESSION['erreur_sql']  = $statement->errorInfo()[2];
            return -1;
        }
        $arr = $statement->errorInfo();
        $statement = null;
        return (int)$this->db->lastInsertId();
    }

    /**
     * Permet d'ajouter un enseignant à la db
     */
    public function add_enseignant(int $id)
    {
        session_start();
        $statement = $this->db->prepare('INSERT INTO Enseignants(IdEnseignant) VALUES (:id);');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        try
        {
            $statement->execute();
        }
        catch (\PDOException $e)
        {
            $_SESSION['erreur_sql']  = $statement->errorInfo()[2];
        }
    }
    /**
     * Permet d'ajouter un élève à la db
     */
    public function add_élève(int $id)
    {
        session_start();
        $statement = $this->db->prepare('INSERT INTO Elèves(IdElève) VALUES (:id);');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        try
        {
            $statement->execute();
        }
        catch (\PDOException $e)
        {
            $_SESSION['erreur_sql']  = $statement->errorInfo()[2];
        }
    }
    /**
     * Permet la connexion d'un utilisateur et renvoie l'array
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * !!!!!! (renvoyer un objet ?) !!!!!!
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function connexion_utilisateur(string $login, string  $mdp)
    {
        session_start();
        $statement = $this->db->prepare("SELECT * FROM Utilisateurs WHERE Login = :login AND MotDePasse = :mdp;");
        $statement->bindParam(':mdp', $mdp, \PDO::PARAM_STR);
        $statement->bindParam(':login', $login, \PDO::PARAM_STR);
        try {
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);
            return $res;
        }
        catch (\PDOException $e) {
            $_SESSION["erreur_sql"] = $e->getMessage();
        }
    }

    /**
     * Get le rôle d'un utilisateur.
     * Penser à la possibilité ou non de cumuler les rôles
     */
    public function get_role_utilisateur(int $id)
    {
        session_start();
        $statementElève = $this->db->prepare("SELECT * FROM Elèves WHERE IdElève = :id;");
        $statementElève->bindParam(":id", $id, \PDO::PARAM_INT);

        $statementProf = $this->db->prepare("SELECT * FROM Enseignants WHERE IdEnseignant = :id;");
        $statementProf->bindParam(":id", $id, \PDO::PARAM_INT);
        try {
            $statementElève->execute();
            $res = $statementElève->fetch(\PDO::FETCH_ASSOC);
            if ($res != null) {
                return "Elève";
            }

            $statementProf->execute();
            $res = $statementProf->fetch(\PDO::FETCH_ASSOC);
            if ($res != null) {
                return "Enseignant";
            }
        }
        catch(\PDOException $e) {
            $_SESSION["erreur_sql"] = $e->getMessage();
        }

        return "Rôle inconnu";
    }

    
    /**
     * Check si un login existe déjà
     */
    public function is_login_free(string $login): bool
    {
        $statement = $this->db->prepare("SELECT * FROM Utilisateurs WHERE login = :login;");
        $statement->bindParam(":login", $login, \PDO::PARAM_STR);
        $statement->execute();
        $res = $statement->fetch();
        return $res == null;
    }




    /**
     * Get les QCM
     */
    public function get_all_qcm()
    {
        $statement = $this->db->prepare("SELECT * FROM QCM");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get le QCM correspondant à l'id
     */
    public function get_qcm(int $id)
    {
        $statement = $this->db->prepare("SELECT * FROM QCM WHERE IdQCM = :id");
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $arr = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $arr = $arr[0];
        return new Qcm($id, $arr['LibelléQCM'], $arr['IdAuteur'], $arr['IdThème']);
    }

    /**
     * Return le nom et prénom de l'auteur du QCM
     */
    public function get_auteur_qcm($id)
    {
        $statement = $this->db->prepare("SELECT * FROM Utilisateurs WHERE IdUtilisateur = :id;");
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        return $arr["Nom"] . ' ' . $arr['Prénom'];
    }

    // /**
    //  * Get les questions d'un QCM
    //  */
    // public function get_questions_qcm($id)
    // {

    // }
}