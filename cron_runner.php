<?php
define('BASEPATH', ''); //Kell, hogy hozz�f�rhessen a database.php-hez
include('frontend/application/config/database.php'); //nem sz�p, de hat�konyabb!

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$time = time() + (5*60); //mennyi ideig nezzen elore a meres (masodpercben)
//5*60 -> 5 perc

if($res = $mysqli->query("SELECT * FROM processes WHERE state = 0 AND runtime < ".$time)){
//minden k�r�sre ami v�rakozik �s az aktu�lis id� +5 percen bel�l futtatand�
  
  while($row = $res->fetch_array()){
    echo $row['id']."<br />";
  }
}else{
  echo $mysqli->error; //debughoz
}

$mysqli->close();
?>