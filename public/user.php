<?php

use App\App;

require "../vendor/autoload.php";

App::getAuth()->requireRole('user','admin');

?>

RÉSERVÉ AUX UTILISATEURS