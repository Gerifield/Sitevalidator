<?php
define('BASEPATH', ''); //Kell, hogy hozzáférhessen a database.php-hez
//include('application/config/database.php'); //nem szép, de hatékonyabb!
include('application/config/database.php'); //nem szép, de hatékonyabb!

//$callback_url = "http://127.0.0.1/index.php/bg/index";
$callback_url = "http://localhost:8080/szd/index.php/bg/index";
//$file_path = "/home/gerifield/Sitevalidator/validator.py";
$file_path = "/home/gerifield/Sitevalidator/validator.py";

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$time = time() + (5*60); //mennyi ideig nezzen elore a meres (masodpercben)
//5*60 -> 5 perc

if($res = $mysqli->query("SELECT * FROM processes WHERE state = 0 AND runtime < ".$time)){
//minden kérésre ami várakozik és az aktuális idõ +5 percen belül futtatandó
  
  while($row = $res->fetch_array()){
//    echo $row['id']."<br />";
    $mysqli->query("UPDATE processes SET state=1 WHERE id = ".$row['id']);
    
    //TODO: futtatás megoldani
//    exec('C:\\Python27\\python.exe validator.py  --callback '.$callback_url.'/'.$row['token'].' '.$row['url'].' > dump.txt &');
   //passthru('/usr/bin/python '.$file_path.' --format silent --callback '.$callback_url.'/'.$row['token'].' '.$row['url'].' &');
   echo shell_exec('/usr/bin/python '.$file_path.' --format silent --callback '.$callback_url.'/'.$row['token'].' '.$row['url'].' > /dev/null & echo "'.$row['id'].' started"');
  //echo $file_path. " -> ".$callback_url;
//  echo '/usr/bin/python '.$file_path.' --format silent --callback '.$callback_url.'/'.$row['token'].' '.$row['url'].' ';  
  }
}else{
  echo $mysqli->error; //debughoz
}

$mysqli->close();
?>
