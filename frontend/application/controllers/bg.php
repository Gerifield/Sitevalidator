<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bg extends CI_Controller {
  
  public function index($token="")
  {
    if(empty($token)){
      echo "Empty transaction token!";
    }else{
    //TODO: Tranzakció kezelés...
    //Minta kód, a bejövõ json-hoz:
    /*
    $json = json_decode(stripslashes($_POST["json-data"])); //kell, különben a \-ek miatt nem érti!
    var_dump($json);

    echo "Decoded: ".stripslashes($_POST["json-data"]);
    file_put_contents("test.txt", stripslashes($_POST["json-data"]));
    */
    
      $json = json_decode(stripslashes($_POST["json-data"]));
      var_dump($json);
      $this->dbmodel->updateProcessResults($token, array( 'state' => 2,
      'htmldoctype' => $json[0][1], 'htmlvalidity' => $json[0][2], 'htmlerrornum' => $json[0][3], 'htmlwarningnum' => $json[0][4],
      'cssdoctype' => $json[0][5], 'cssvalidity' => $json[0][6], 'csserrornum' => $json[0][7], 'csswarningnum' => $json[0][8]));
      echo "Success";
    }
  }

}

/* End of file bg.php */
/* Location: ./application/controllers/bg.php */