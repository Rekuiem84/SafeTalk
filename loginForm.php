<?php
require "./classes/db.php";
require "./classes/form.php";
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
  if ($form->isValidLoginForm()) {
    if ($login->checkAccess($email, $mdp)) {
      var_dump($_POST);
      $userData = $form->getUserData($email)[0];
      // ajouter un array avec toutes les infos du man avec une fonction de membre
      $user = new User($email, $mdp, 0);
      $user->setSession();
      $login->connect();
    } else {
      $message = "Email ou mot de passe incorrect";
      header("Location: loginForm.php?error");
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
  <title>Authentification — SafeTalk</title>
  <meta name='description' content="Page d'authentification de SafeTalk">
  <link rel='stylesheet' href='./assets/style/general.css' />
  <link rel='stylesheet' href='./assets/style/style.css' />
  <link rel='shortcut icon' type='image/png' href='' />
  <script src='' defer></script>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="registration">
  <header>
    <div class="logo-cont"><img src="./assets/images/logo-long.png" alt="logo"></div>
  </header>
  <main class="section-padding-m">
    <div class="illustration-cont"><img src="./assets/images/login-illustration.svg" alt="illustration"></div>
    <div class="form-cont">
      <form method="post">
        <h1 class="underline">Se connecter</h1>
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
        <div class="button-cont">
          <button>Se connecter</button>
          <a href="./newAccount.php" class="underline">Créer un compte</a>
        </div>
        <?php
        if (isset($_GET["error"])) :
        ?>
          <div data-error class="data-form-result">
            <p>Email ou mot de passe incorrect</p>
            <p><label for="email" class="underline">Réessaie</label> ou <a href="newAccount.php" class="underline">crée un compte</a></p>
          </div>
        <?php
        endif;
        ?>
      </form>
    </div>
  </main>

</body>

</html>