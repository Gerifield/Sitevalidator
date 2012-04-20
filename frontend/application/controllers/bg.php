<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bg extends CI_Controller {
  
  public function index($token="")
  {
    if(empty($token)){
      echo "Empty transaction token!";
    }else{
    //TODO: Tranzakció kezelés...
    //Minta kód, a bejövő json-hoz:
    /*
    $json = json_decode(stripslashes($_POST["json-data"])); //kell, különben a \-ek miatt nem érti!
    var_dump($json);

    echo "Decoded: ".stripslashes($_POST["json-data"]);
    file_put_contents("test.txt", stripslashes($_POST["json-data"]));
    */
    
      $json = json_decode(stripslashes($_POST["json-data"]));
      var_dump($json);
      $this->dbmodel->getProcDataByToken($token);
      $this->dbmodel->updateProcessResults($token, array( 'state' => 2, 'starttime' => time())); //befrissitjuk
      
      $pdata = $this->dbmodel->getProcDataByToken($token);
      $this->dbmodel->delPageData($pdata['id'], $pdata['uid']); //korabbi hozzatartozokat toroljuk
      var_dump($pdata);
      
      $ishtmlvalid = 1;
      $iscssvalid = 1;
      
      foreach($json as $row){
        $this->dbmodel->addPageData(array('pid' => $pdata['id'], 'uid' => $pdata['uid'], 'url' => $row->url, 'code' => $row->code, 'runtime' => time(),
        'htmldoctype' => $row->htmldoctype, 'htmlvalidity' => $row->htmlvalidity, 'htmlerrornum' => $row->htmlerrornum, 'htmlwarningnum' => $row->htmlwarningnum,
        'cssdoctype' => $row->cssdoctype, 'cssvalidity' => $row->cssvalidity, 'csserrornum' => $row->csserrornum, 'csswarningnum' => $row->csswarningnum,
        'htmlsize' => $row->htmlsize, 'fullcsssize' => $row->fullcsssize, 'fulljssize' => $row->fulljssize, 'imgnum' => $row->imgnum));
        //TODO: lehet $row eleg lenne....
        if($row->htmlvalidity == 0){ //nem valid egy oldal
          $ishtmlvalid = 0;
        }
        if($row->cssvalidity == 0){
          $iscssvalid = 0;
        }
      }
      
      //ebbe is kerülhetne a kész jelzés, de akkor az ütemező bekavarhat talán...
      $this->dbmodel->updateProcessResults($token, array( 'htmlvalidity' => $ishtmlvalid, 'cssvalidity' => $iscssvalid ));
      echo "Success";
      
      
      //E-mail generálás
      if($pdata['sendMail']){
        $this->load->library('email');
        $this->email->from('noreply@sitevalidator.hu', 'Sitevalidator');
        $this->email->to($this->dbmodel->getEmailByUid($pdata['uid']));
        
        $this->email->subject('Sitevalidator elemzés '.date("Y-m-d H:i", time()));
        
        $msg = 'Ezt az üzenetet a rendszer automatikusan generálta, ne válaszoljon rá!
A validálás lefutott: '.date("Y-m-d H:i", time()).'
Összesített eredmény:
HTML: '.$ishtmlvalid==0?'Invalid':'Valid'.'
CSS: '.$iscssvalid==0?'Invalid':'Valid'.'

Részletek:
';
        foreach($json as $row){
$msg .= 'URL: '.$row->url.'
HTML: '.$row->htmlvalidity.'
HTML Doctype: '.$row->htmldoctype.'
CSS: '.$row->htmlvalidity.'
CSS Doctype: '.$row->cssdoctype.'

';
        }
        
        $this->email->message($msg);
        
        $this->email->send();
        echo $this->email->print_debugger();
      }
      
    }
  }

}

/* End of file bg.php */
/* Location: ./application/controllers/bg.php */