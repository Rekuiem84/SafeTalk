<?php

class Form
{
    // Cette fonction vérifie si le formulaire a été soumis 
    public function isSubmitted(): bool
    {
        return !empty($_POST);
    }

    // Cette fonction vérifie tous les champs du formulaire de login sont remplis
    public function isValidLoginForm(): bool
    {
        return (!empty($_POST["email"]) && !empty($_POST["password"]));
    }

    // Cette fonction renvoie un array avec les erreurs de validation du formulaire
    public function getErrorsLogin(): array
    {
        $errors = [
            "email" => empty($_POST["email"]) ? "Merci de renseigner votre email" : "",
            "password" => empty($_POST["password"]) ? "Merci de renseigner votre mot de passe" : ""
        ];
        return $errors;
    }

    // Cette fonction vérifie si les champs spécifiés dans le paramètre $params sont valides (non vides)
    // $params est un array
    public function isValidAnyForm($params): bool
    {
        foreach ($params as $param) {
            if (empty($param)) {
                return false;
            }
        }
        return true;
    }

    // Renvoie un array avec toutes les données de l'utilisateur
    public function getUserData($email): array
    {
        $db = new Db;
        $co = $db->dbCo("SafeTalk", "root", "root");

        $sql = "SELECT * FROM `user` WHERE email = ?";
        $param = [$email];
        $result = $db->SQLWithParam($sql, $param, $co);
        return $result;
    }
}
