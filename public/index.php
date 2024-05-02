<?php

use App\Auth;
use App\App; 

require '../vendor/autoload.php';

$server = 'localhost';
$login = 'root';
$password = '';

$pdo = App::getPDO();

$users = $pdo->query('SELECT * FROM users')->fetchAll();
$auth = App::getAuth();
$user = $auth->user();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>Accéder aux Pages</h1>

    <?php if(isset($_GET['login'])): ?>
        <div class="alert alert-success">
            Vous êtes bien identifié
        </div>
    <?php endif; ?>

    <?php if($user): ?>
        <p>Vous êtes connecté en tant que <?= $user->username; ?> - 
        <a href="logout.php">Se déconnecter</a>
        </p>
    <?php endif; ?>

    <ul>
        <li><a href="admin.php">Page réservée à l'Aministrateur</a></li>
        <li><a href="user.php">Page réservée à l'Utilisateur</a></li>
    </ul>
</body>
</html>