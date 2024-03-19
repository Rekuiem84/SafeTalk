<?php


class Db
{


    /**
     * Pour se connecter à la BDD
     * 
     * Paramètres : 
     * - $dbName (string) : nom de la BDD
     * - $login (string) : nom d'utilisateur
     * - $password (string) : mot de passe
     * 
     * Retour : objet PDO ($db) OU erreur
     * 
     */
    public function dbCo($dbName, $login, $password)
    {
        try {
            $db = new PDO(
                "mysql:host=localhost;
                    dbname=" . $dbName . ";
                    charset=utf8",
                $login,
                $password
            );
            return $db;
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }





    /**
     * Pour créer une requête SQL sans paramètre
     * 
     * Paramètres de la fonction : 
     * - $sql (string) : requête SQL
     * - $db (objet) : résultante de la fonction "dbCo()"
     * 
     * Retour : array
     * 
     */
    public function SQLWithoutParam($sql, $db)
    {
        $response = $db->query($sql);

        $data = $response->fetchAll();

        $response->closeCursor();

        return $data;
    }


    /**
     * Pour créer une requête SQL avec paramètres
     * 
     * Paramètres de la fonction : 
     * - $sql (string) : requête SQL
     * - $param (array) : paramètres de la requête SQL
     * - $db (objet) : résultante de la fonction "dbCo()"
     * 
     * Retour : array
     * 
     */
    public function SQLWithParam($sql, $param, $db)
    {
        $response = $db->prepare($sql);
        $response->execute($param);

        $data = $response->fetchAll();
        return $data;
    }
}
