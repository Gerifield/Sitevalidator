<?php
define('BASEPATH', ''); //Kell, hogy hozzáférhessen a database.php-hez
include('frontend/application/config/database.php'); //nem szép, de hatékonyabb!

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$mysqli->close();
?>