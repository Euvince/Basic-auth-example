<?php

use App\App;

require "../vendor/autoload.php";

App::getAuth()->requireRole('admin');

?>

RÉSERVÉ AUX ADMINS