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
      header("Location: newAccount.php?success");
    } else {
      header("Location: newAccount.php?error");
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
  <link rel='stylesheet' href='./assets/style/general.css' />
  <link rel='stylesheet' href='./assets/style/style.css' />
  <link rel='shortcut icon' type='image/png' href='' />
  <script src='' defer></script>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="registration">
  <header>
    <div class="logo-cont"><a href="./loginForm.php"><img src="./assets/images/logo-long.png" alt="logo"></a></div>
  </header>
  <main class="section-padding-m">
    <div class="illustration-cont"><img src="./assets/images/login-illustration.svg" alt="illustration"></div>
    <div class="form-cont">
      <form method="post">
        <h1 class="underline">Créer un compte</h1>
        <div class="field-cont"><label for="email"><i class='bx bxs-user'></i>Email</label><input type="email" name="email" id="email" value="<?php if ($form->isSubmitted()) {
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
        <div class="field-cont"><label for="password"><i class='bx bxs-lock-alt'></i>Mot de passe</label><input type="password" name="password" id="password">
          <p><?php if ($form->isSubmitted()) {
                if (!($form->isValidLoginForm($params))) {
                  echo $errors["password"];
                }
              } ?></p>
        </div>
        <div class="button-cont"><button>Créer mon compte</button></div>

        <?php
        if (isset($_GET["success"])) :
        ?>
          <div data-success class="data-form-result">
            <p>Compte créé avec succès</p>
            <p><a href="loginForm.php" class="underline">Se connecter</a></p>
          </div>
        <?php
        endif;
        ?>
        <?php
        if (isset($_GET["error"])) :
        ?>
          <div data-error class="data-form-result">
            <p>Cet email est déjà utilisé.</p>
          </div>
        <?php
        endif;
        ?>
      </form>
    </div>
  </main>

</body>




</html>