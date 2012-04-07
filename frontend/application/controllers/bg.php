<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bg extends CI_Controller {
  
  public function index($id="")
  {
    if(empty($id)){
      echo "Empty transaction id!";
    }else{
    //TODO: Tranzakció kezelés...
    //Minta kód, a bejövõ json-hoz:
    /*
    $json = json_decode(stripslashes($_POST["json-data"])); //kell, különben a \-ek miatt nem érti!
    var_dump($json);

    echo "Decoded: ".stripslashes($_POST["json-data"]);
    file_put_contents("test.txt", stripslashes($_POST["json-data"]));
    */
    }
  }

}

/* End of file bg.php */
/* Location: ./application/controllers/bg.php */