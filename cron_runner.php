<?php
define('BASEPATH', ''); //Kell, hogy hozz�f�rhessen a database.php-hez
include('frontend/application/config/database.php'); //nem sz�p, de hat�konyabb!

$callback_url = "http://127.0.0.1/SZAKDOLI/frontend/index.php/bg/index";

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$time = time() + (5*60); //mennyi ideig nezzen elore a meres (masodpercben)
//5*60 -> 5 perc

if($res = $mysqli->query("SELECT * FROM processes WHERE state = 0 AND runtime < ".$time)){
//minden k�r�sre ami v�rakozik �s az aktu�lis id� +5 percen bel�l futtatand�
  
  while($row = $res->fetch_array()){
    echo $row['id']."<br />";
    $mysqli->query("UPDATE processes SET state=1 WHERE id = ".$row['id']);
    
    //TODO: futtat�s megoldani
    exec('C:\\Python27\\python.exe validator.py  --callback '.$callback_url.'/'.$row['token'].' '.$row['url'].' > dump.txt &');
    
  }
}else{
  echo $mysqli->error; //debughoz
}

$mysqli->close();
?>