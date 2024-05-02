<?php

require '../vendor/autoload.php';

use App\Auth;
use App\App;

session_start();

$auth = App::getAuth();

$error = false;

if($auth->user() !== null) {
    header('Location: index.php');
    exit();
}

if (!empty($_POST)) {

    $user = $auth->login($_POST['username'], $_POST['password']);
    
    if ($user) {
        header('Location: admin.php?login=1');
        exit();
    }
    $error = true;
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
</head>
<body class="p-4">

    <h1>Se connecter</h1>

    <?php if($error): ?>
        <div class="alert alert-danger">
            Identifiant ou mot de passe incorrect
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['forbid'])): ?>
        <div class="alert alert-danger">
            ACCÈS INTERDIT
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Pseudo">
        </div>

        <div class="form-group mt-3">
            <input type="password" class="form-control" name="password" placeholder="Mot de Passe">
        </div>

        <button class="btn btn-primary mt-3">Se connecter</button>
    </form>
</body>
</html>