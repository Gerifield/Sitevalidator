<?php
define('BASEPATH', ''); //Kell, hogy hozz�f�rhessen a database.php-hez
include('frontend/application/config/database.php'); //nem sz�p, de hat�konyabb!

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$mysqli->close();
?>