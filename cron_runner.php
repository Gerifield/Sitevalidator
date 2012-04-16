<?php
define('BASEPATH', ''); //Kell, hogy hozzáférhessen a database.php-hez
include('frontend/application/config/database.php'); //nem szép, de hatékonyabb!

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$time = time() + (5*60); //mennyi ideig nezzen elore a meres (masodpercben)
//5*60 -> 5 perc

if($res = $mysqli->query("SELECT * FROM processes WHERE state = 0 AND runtime < ".$time)){
//minden kérésre ami várakozik és az aktuális idõ +5 percen belül futtatandó
  
  while($row = $res->fetch_array()){
    echo $row['id']."<br />";
  }
}else{
  echo $mysqli->error; //debughoz
}

$mysqli->close();
?>