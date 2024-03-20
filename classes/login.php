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


    /* Check dans la DB s'il y a une correspondance entre $email et sha1($mdp) */
    public function checkAccess($email, $mdp): bool
    {
        $db = new Db;
        $co = $db->dbCo("SafeTalk", "root", "root");

        $sql = "SELECT `email`, SHA1(`password`) password FROM `user` WHERE `email` = ? AND `password` = ?";
        $param = [$email, sha1($mdp)];
        $result = $db->SQLWithParam($sql, $param, $co);
        return !empty($result);
    }

    /* Check dans la DB si le mail existe déjà */
    public function userExists($email): bool
    {
        $db = new Db;
        $co = $db->dbCo("SafeTalk", "root", "root");

        $sql = "SELECT `email` FROM `user` WHERE email = ?";
        $param = [$email];
        $result = $db->SQLWithParam($sql, $param, $co);
        return !empty($result);
    }

    // Redirige vers la page de dashboard
    public function connect(): void
    {
        header("Location: dashboard.php");
    }
}
