<?php
declare(strict_types= 1);
namespace Qcm\Models;
use Qcm\Classes\Utilisateur;
include_once("Classes/Utilisateur.php");
use Qcm\Classes\Enseignant;
include_once("Classes/Enseignant.php");
use Qcm\Classes\Elève;
include_once("Classes/Elève.php");

session_start();

/**
 * Classe prenant en charge les requètes concernant les utilisateurs.
 * Gère aussi les Enseignants et Elèves.
 */
class UtilisateurModel
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = new \PDO("mysql:host=localhost;dbname=qcm_V3;charset=utf8","root","E12alt%F4");
    }

    /**
     * Renvoie l'utilisateur'à l'ID spécifié ou null si not exists
     */
    public function get_utilisateur(int $id): ?Utilisateur
    {
        $statement = $this->db->prepare("SELECT * FROM Utilisateurs WHERE IdUtilisateur = :id");
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $arr = $statement->fetch(\PDO::FETCH_ASSOC);
        return new Utilisateur($arr['IdUtilisateur'], $arr['Nom'], $arr['Prénom'], $arr['Login'], $arr['MotDePasse']);
        //return $arr;
    }


    /**
     * Supprimer un utilisateur de la db
     */
    public function delete_utilisateur(int $id): bool
    {
        $statement = $this->db->prepare("DELETE FROM Utilisateurs WHERE IdUtilisateur = :id");
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }


    /**
     * Renvoie l'id d'un utilisateur si son mot de passe et son login correspondent
     * ps: Peut écrire une erreur dans la session, mauvaise pratique -> à surveiller
     * @return int
     */
    public function check_credentials(string $login, string  $mdp): int
    {
        session_start();
        $statement = $this->db->prepare("SELECT * FROM Utilisateurs WHERE Login = :login AND MotDePasse = :mdp;");
        $statement->bindParam(':mdp', $mdp, \PDO::PARAM_STR);
        $statement->bindParam(':login', $login, \PDO::PARAM_STR);
        try {
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);
            if($res != null)
            {
                return $res['IdUtilisateur'];
            }
        }
        catch (\PDOException $e) {
            $_SESSION["erreur_sql"] = $e->getMessage();
        }
        return -1;
    }


    /**
     * Connaitre le rôle d'un utilisateur pour update la session
     * @param int $id L'id de l'utilisateur dont on return le rôle
     * @return string Une chaîne à switch
     */
    public function get_role_utilisateur($id): string
    {
        $statementElève = $this->db->prepare("SELECT * FROM Elèves WHERE IdElève = :id;");
        $statementElève->bindParam(":id", $id, \PDO::PARAM_INT);

        $statementProf = $this->db->prepare("SELECT * FROM Enseignants WHERE IdEnseignant = :id;");
        $statementProf->bindParam(":id", $id, \PDO::PARAM_INT);
        try {
            $statementElève->execute();
            $res = $statementElève->fetch(\PDO::FETCH_ASSOC);
            if ($res != null) {
                // return [
                //     "role" => "Elève",
                //     "user" => new Elève(
                //         (int)$id,
                //         $user->get_nom(),
                //         $user->get_prénom(),
                //         $user->get_login(),
                //         $user->get_mot_de_passe()
                //     )
                // ];
                return "Elève";
            }

            $statementProf->execute();
            $res = $statementProf->fetch(\PDO::FETCH_ASSOC);
            if ($res != null) {
                // return [
                //     "role" => "Enseignant",
                //     "user" => new Enseignant(
                //         (int)$id,
                //         $user->get_nom(),
                //         $user->get_prénom(),
                //         $user->get_login(),
                //         $user->get_mot_de_passe()
                //     )
                // ];
                return "Enseignant";
            }
        }
        catch(\PDOException $e) {
            $_SESSION["erreur_sql"] = $e->getMessage();
        }

        return "Rôle inconnu";
    }


    /**
     * Return tous les utilisateurs
     * @param string $role : Le rôle des utilisateurs à return, null par défaut.
     * 
     * @return Utilisateur[]
     */
    public function get_all_utilisateurs(string $role = null): array
    {
        $res = [];
        if($role == null)
        {
            $statement = $this->db->prepare("SELECT * FROM Utilisateurs;");
        }
        else if ($role == "enseignant")
        {
            $statement = $this->db->prepare("SELECT Utilisateurs.* FROM Utilisateurs, Enseignants WHERE IdUtilisateur = IdEnseignant;");
        }
        else if ($role == "élève")
        {
            $statement = $this->db->prepare("SELECT Utilisateurs.* FROM Utilisateurs, Elèves WHERE IdUtilisateur = IdElève;");
        }
        $statement->execute();
        foreach($statement->fetchAll(\PDO::FETCH_ASSOC) as $arr)
        {
            $user = new Utilisateur($arr['IdUtilisateur'], $arr['Nom'], $arr['Prénom'], $arr['Login'], $arr['MotDePasse']);
            array_push($res, $user); 
        }

        return $res;
    }


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
     * Return true si le login n'est pas déjà utilisé
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
}