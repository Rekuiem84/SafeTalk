<?php

class User
{
  private $id;
  private $nom;
  private $prenom;
  private $email;
  private $mdp;
  private $is_admin;
  private $age;
  private $school;


  public function getId()
  {
    return $this->id;
  }
  public function getNom()
  {
    return $this->nom;
  }
  public function getPrenom()
  {
    return $this->prenom;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getMdp()
  {
    return $this->mdp;
  }
  public function getIsAdmin()
  {
    return $this->is_admin;
  }
  public function getAge()
  {
    return $this->age;
  }
  public function getSchool()
  {
    return $this->school;
  }

  public function setNom($nom)
  {
    $this->nom = $nom;
  }
  public function setPrenom($prenom)
  {
    $this->prenom = $prenom;
  }
  public function setEmail($email)
  {
    $this->email = $email;
  }
  public function setMdp($mdp)
  {
    $this->mdp = $mdp;
  }
  public function setIsAdmin($is_admin)
  {
    $this->is_admin = $is_admin;
  }
  public function setAge($age)
  {
    $this->age = $age;
  }
  public function setSchool($school)
  {
    $this->school = $school;
  }

  public function __construct($email, $mdp, $is_admin, $id = null, $nom = null, $prenom = null, $age = null, $school = null)
  {
    $this->id = $id;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->email = $email;
    $this->mdp = $mdp;
    $this->is_admin = $is_admin;
    $this->age = $age;
    $this->school = $school;
  }

  // Ajoute un nouveau membre dans la DB
  public function insertMembre($email, $mdp, $admin = 0): void
  {
    $co = new Db;
    $db = $co->dbCo("SafeTalk", "root", "root");

    $sql = "INSERT INTO `user` (`email`,`password`,`is_admin`) VALUES (?,?,?)";
    $param = [$email, sha1($mdp), intval($admin)];
    $co->SQLWithParam($sql, $param, $db);
  }

  // Récupère un membre dans la DB et le retourne
  public function getMembre($id): User
  {
    $co = new Db();
    $db = $co->dbCo("SafeTalk", "root", "root");

    /* Utilisation de la fonction SQLWithParam */
    $sql = "SELECT * FROM `user` where id=?";
    $param = [$id];
    $datas = $co->SQLWithParam($sql, $param, $db);

    if (!empty($datas)) {
      $membre = $datas[0];

      $this->nom = $membre["nom"];
      $this->prenom = $membre["prenom"];
      $this->email = $membre["email"];
      $this->mdp = $membre["mot_de_passe"];
      $this->is_admin = $membre["is_admin"];
      $this->age = $membre["age"];
      $this->school = $membre["school"];
    }
    return $this;
  }

  // Met à jour les informations d'un membre dans la DB
  public function setMembre($nom, $prenom, $email, $mdp, $id, $age, $school): void
  {
    $_SESSION["membre_prenom"] = $prenom;
    $_SESSION["membre_nom"] = $nom;
    $_SESSION["membre_email"] = $email;
    $_SESSION["membre_age"] = $age;
    $_SESSION["membre_school"] = $school;

    $co = new Db();
    $db = $co->dbCo("SafeTalk", "root", "root");

    $sql = "UPDATE `user` SET `nom`=?, `prenom`=?, `email`=?, `password`=?, `age`=?, `school`=?, WHERE id=?";
    $param = [$nom, $prenom, $email, $mdp, $age, $school, $id];
    $datas = $co->SQLWithParam($sql, $param, $db);
  }

  // Enregistre les informations du membre dans la session
  public function setSession(): void
  {
    $_SESSION["is_connected"] = true;
    $_SESSION["is_admin"] = $this->is_admin;
    $_SESSION["membre_id"] = $this->id;
    $_SESSION["membre_prenom"] = $this->prenom;
    $_SESSION["membre_nom"] = $this->nom;
    $_SESSION["membre_email"] = $this->email;
    $_SESSION["membre_age"] = $this->age;
    $_SESSION["membre_school"] = $this->school;
  }
}
