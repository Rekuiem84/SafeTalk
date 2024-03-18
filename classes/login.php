<?php

class Login
{

    private $id;

    private $email;

    private $mdp;


    public function getID()
    {
        return $this->id;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getMdp()
    {
        return $this->mdp;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setMotdepasse($mdp)
    {
        $this->mdp = $mdp;
    }

    /* Doit renvoyer un bool*/
    public function checkAccess($email, $mdp)
    {
        $db = new Db;
        $co = $db->dbCo("panza", "root", "root");

        $sql = "SELECT `email`, SHA1(`mot_de_passe`) mot_de_passe FROM `membre` WHERE email = ? AND mot_de_passe = ?";
        $param = [$email, sha1($mdp)];
        $result = $db->SQLWithParam($sql, $param, $co);
        return !empty($result);
    }

    public function connect()
    {
        header("Location: dashboard.php");
    }
}
