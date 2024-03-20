<?php
require "./classes/db.php";
require "./classes/form.php";
require "./classes/user.php";
require "./classes/login.php";

session_start();

$form = new Form;
$login = new Login;
$params = [];
$errors = [];
$message = "";

if ($form->isSubmitted()) {
  $email = $_POST["email"];
  $mdp = $_POST["password"];
  $params = [$email, $mdp];
  if ($form->isValidAnyForm($params)) {

    // Vérifie si l'email existe PAS déjà
    if (!$login->userExists($email)) {
      // Ajouter un nouvel utilisateur
      $user = new User($email, $mdp, 0);
      $user->insertMembre($email, $mdp);
      $message = "Votre compte a été créé avec succès";
      header("Location: newAccount.php?success");
    } else {
      $message = "Cet email est déjà utilisé.";
    }
  } else {
    $errors = $form->getErrorsLogin();
  }
}

?>
<!DOCTYPE html>
<html lang='fr'>

<head>
  <meta charset='UTF-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Créer un compte — SafeTalk</title>
  <meta name='description' content="Page d'authentification de SafeTalk">
  <link rel='stylesheet' href='./assets/style/style.css' />
  <link rel='shortcut icon' type='image/png' href='' />
  <script src='' defer></script>
</head>

<body>
  <main>
    <div class="form-cont">
      <h1>Créer un compte</h1>
      <form method="post">
        <div><label for="email">Email</label><input type="email" name="email" id="email" value="<?php if ($form->isSubmitted()) {
                                                                                                  if (!empty($_POST["email"])) {
                                                                                                    echo $_POST["email"];
                                                                                                  }
                                                                                                } ?>">
          <p><?php if ($form->isSubmitted()) {
                if (!($form->isValidLoginForm($params))) {
                  echo $errors["email"];
                }
              } ?></p>
        </div>
        <div><label for="password">Mot de passe</label><input type="password" name="password" id="password">
          <p><?php if ($form->isSubmitted()) {
                if (!($form->isValidLoginForm($params))) {
                  echo $errors["password"];
                }
              } ?></p>
        </div>
        <button>Valider</button>
      </form>
    </div>
    <?php
    if (isset($_GET["success"])) :
    ?>
      <p>Compte crée avec succès</p>
      <p><a href="loginForm.php">Se connecter</a></p>
    <?php
    endif;
    ?>
  </main>
</body>

</html>