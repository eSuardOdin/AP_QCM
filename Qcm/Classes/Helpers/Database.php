<?php
declare(strict_types= 1);
namespace Qcm\Helpers;

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
        $statement = $this->db->prepare("INSERT INTO Utilisateur(Nom, Prénom, Login, MotDePasse) VALUES (? , ? , ? , ?);");
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

    public function connexion_utilisateur(string $login, string  $mdp)
    {
        session_start();
        $statement = $this->db->prepare("SELECT * FROM Utilisateur WHERE Login = :login AND MotDePasse = :mdp;");
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


}