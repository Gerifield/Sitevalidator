<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bg extends CI_Controller {
  
  public function index($token="")
  {
    if(empty($token)){
      echo "Empty transaction token!";
    }else{
    //TODO: Tranzakci� kezel�s...
    //Minta k�d, a bej�v� json-hoz:
    /*
    $json = json_decode(stripslashes($_POST["json-data"])); //kell, k�l�nben a \-ek miatt nem �rti!
    var_dump($json);

    echo "Decoded: ".stripslashes($_POST["json-data"]);
    file_put_contents("test.txt", stripslashes($_POST["json-data"]));
    */
    
      $json = json_decode(stripslashes($_POST["json-data"]));
      var_dump($json);
      $this->dbmodel->getProcDataByToken($token);
      $this->dbmodel->updateProcessResults($token, array( 'state' => 2, 'starttime' => time())); //befrissitjuk
      
      $pdata = $this->dbmodel->getProcDataByToken($token);
      $this->dbmodel->delPageData($pdata['pid'], $pdata['uid']); //korabbi hozzatartozokat toroljuk
      
      foreach($json as $row){
        $this->dbmodel->addPageData($pdata['pid'], $pdata['uid'], array('url' => $row['url'], 'code' => $row['code'], 'runtime' => time(),
        'htmldoctype' => $row['htmldoctype'], 'htmlvalidity' => $row['htmlvalidity'], 'htmlerrornum' => $row['htmlerrornum'], 'htmlwarningnum' => $row['htmlwarningnum'],
        'cssdoctype' => $row['cssdoctype'], 'cssvalidity' => $row['cssvalidity'], 'csserrornum' => $row['csserrornum'], 'csswarningnum' => $row['csswarningnum'],
        'htmlsize' => $row['htmlsize'], 'fullcsssize' => $row['fullcsssize'], 'fulljssize' => $row['fulljssize'], 'imgnum' => $row['imgnum']));
        //TODO: lehet $row eleg lenne....
      }
      /*
      array('htmldoctype' => $json[0][1], 'htmlvalidity' => $json[0][2], 'htmlerrornum' => $json[0][3], 'htmlwarningnum' => $json[0][4],
      'cssdoctype' => $json[0][5], 'cssvalidity' => $json[0][6], 'csserrornum' => $json[0][7], 'csswarningnum' => $json[0][8]));
      echo "Success";
      */
    }
  }

}

/* End of file bg.php */
/* Location: ./application/controllers/bg.php */