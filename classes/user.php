<?php

class User
{
  private $id;
  private $nom;
  private $prenom;
  private $email;
  private $mdp;
  private $is_admin;


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

  public function __construct($email, $mdp, $is_admin)
  {
    $this->email = $email;
    $this->mdp = $mdp;
    $this->is_admin = $is_admin;
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
    }
    return $this;
  }

  // Met à jour les informations d'un membre dans la DB
  public function setMembre($nom, $prenom, $email, $mdp, $id): void
  {
    $_SESSION["membre_prenom"] = $prenom;
    $_SESSION["membre_nom"] = $nom;
    $_SESSION["membre_email"] = $email;

    $co = new Db();
    $db = $co->dbCo("SafeTalk", "root", "root");

    $sql = "UPDATE `user` SET `nom`=?, `prenom`=?, `email`=?, `password`=? WHERE id=?";
    $param = [$nom, $prenom, $email, $mdp, $id];
    $datas = $co->SQLWithParam($sql, $param, $db);
  }
}
