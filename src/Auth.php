<?php

namespace App;

use PDO;

class Auth {

    private $pdo;

    private $loginPath;

    public function __construct(PDO $pdo, string $loginPath)
    {
        $this->pdo = $pdo;
        $this->loginPath = $loginPath;
    }

    public function user (): ?User
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_SESSION['auth'] ?? null;
        if($id === null) {
            return null;
        }

        $query = $this->pdo->prepare('SELECT * FROM users WHERE id: ?');
        $query->execute([$id]);
        $query->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $query->fetch();

        return $user ?:null;
    }

    public function login(string $username, $password): ?User
    {
        //TROUVER L'UTILISATEUR CORRESPONDANT AU USERNAME
        $query = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(['username' => $username]);
        $query->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $query->fetch();

        if ($user === false) {
            return null;
        }

        //VERIFICATION DU MOT DE PASSE
        if (password_verify($password, $user->password)) {
           if (session_status() === PHP_SESSION_NONE) {
                session_start();
           }
            $_SESSION['auth'] = $user->id;
            return $user;
        }
        return null;
    }


    public function requireRole(string ...$roles): void
    {
        $user = $this->user();
        if($user === null || !in_array($user->role, $roles)) {
            header("Location: {$this->loginPath}?forbid=1");
            exit();
        }
    }

}