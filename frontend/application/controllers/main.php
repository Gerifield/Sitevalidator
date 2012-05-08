<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  var $ext_regex = "/(htm|html|php|asp|xml)$/";

	public function index()
	{
    if($this->session->userdata('logged_in')){      
      $inurl = $this->input->post("inurl", TRUE);
      $data["inurl"] = $inurl;
      $data["runtime"] = $this->input->post("runtime", TRUE);
      $data["sendemail"] = $this->input->post("sendemail", TRUE) ? 1 : 0;
      $data["repeat"] = $this->input->post("repeat", TRUE);
      if($this->input->post("sendform", TRUE)){
        if($inurl){
          //TODO kódolás
          $stamp = strtotime($this->input->post("runtime", TRUE));
          if($stamp && $stamp > time()-60){ //regen -1 volt 5.1.0 elott
          //print "OK";
          //print $stamp." -> ".date("Y-m-d H:i", $stamp);
            if(preg_match("/^(http|https):\/\//", $inurl)){
              if(preg_match($this->ext_regex, $inurl)){
                
                if(!is_numeric($data["repeat"])){ //ha hamis vagy nem szám, akkor nullázzuk
                  $data["repeat"] = 0;
                }else{
                  $data["repeat"] = $data["repeat"] * 86400; //24 * 60 * 60 = 86400 másodpercre váltjuk
                }
                
                $this->dbmodel->addNewProcess($inurl, $stamp, $data["sendemail"], $data["repeat"],  $this->dbmodel->getUidByUser($this->session->userdata("user")));
                $data["successmsg"] = "Sikeres hozzáadás!";
                //kinullázzuk, már nem kell
                $data["inurl"] = "";
                $data["runtime"] = "";
                $data["sendemail"] = 0;
                $data["repeat"] = "";
                
              }else{
                $data["errormsg"] = "Az URL-nek .htm, .html, .php, .asp vagy .xml-re kell végződnie.";
              }
            }else{
              $data["errormsg"] = "Az URL-nek http-vel vagy https-el kell kezdődnie!";
            }
          }else{
            $data["errormsg"] = "Rossz dátum formázás.";
          }
        }else{
          $data["errormsg"] = "Ki kell tölteni az URL mezőt!";
        }
      }
      $data["datalist"] = $this->dbmodel->getShortProcessDataByUid($this->dbmodel->getUidByUser($this->session->userdata('user')));
      $this->load->view('header');
      $this->load->view('menu');
      $this->load->view('content_main', $data);
      $this->load->view('footer');
    }else{
      redirect("main/login");
    }
	}
  
  public function login(){
    
    $data["allowedReg"] = $this->dbmodel->checkRegEnabled();
    $user = $this->input->post("user", TRUE);
    $pass = sha1($this->input->post("pass", TRUE));
    
    if($user){ //ha nem ures az usernev
      if($this->dbmodel->checkLogin($user, $pass)){
        $this->session->set_userdata( array( "logged_in" => true, "user" => $user) );
        redirect("main/index");
      }else{
        $data["errormsg"] = "Hibás felhasználónév vagy jelszó!";
      }
    }
    $data["user"] = $user; //atadjuk, kenyelmi okokbol....
    //vagy ures az user, vagy valamilyen hibat kapott $data["errormsg"]-be
    $this->load->view('header');
    $this->load->view('content_login', $data);
    $this->load->view('footer');
  }
  
  public function logout(){
      $this->session->set_userdata("logged_in", false);
      $this->session->sess_destroy();
      redirect("main/index");
  }
    
  public function profile(){
    if($this->session->userdata('logged_in')){
      
      $email = $this->input->post("email", TRUE);
      $pass1 = $this->input->post("pass1", TRUE);
      $pass2 = $this->input->post("pass2", TRUE);
      
      if($pass1){ //ha van benne adat
        if($pass1 == $pass2){
          //pass módosítva
          $this->dbmodel->updatePass($this->session->userdata("user"), sha1($pass1));
          $data["successmsg"] = "Sikeres jelszó módosítás!"; //csak akkor, ha tenyleg modosult
        }else{
          $data["errormsg"] = "Nem egyezik a két jelszó!"; //ha nem passzolt a 2 jelszo
        }
      }
      if($email){ //ha nem üres, frissítjük
        if($this->dbmodel->checkEmail($email)){
          $this->dbmodel->updateEmail($this->session->userdata("user"), $email);
          if(!isset($data["successmsg"])){ //ha nem módosult a jelszó, akkor írjuk ezt ki (vagyis mindig, amikor a formot elkuldik)
            $data["successmsg"] = "Sikeres e-mail módosítás!";
          }
        }else{
          if(!isset($data["errormsg"])){
            $data["errormsg"] = "Már folgalt ez az e-mail cím!";
          }
        }
      }
      
      $query = $this->dbmodel->getUserData($this->session->userdata("user")); //DB-bol kerjuk le, az a biztos
      $data["email"] = $query["email"];
      
      $this->load->view('header');
      $this->load->view('menu');
      $this->load->view('content_profile', $data);
      $this->load->view('footer');
    }else{
      redirect("main/login");
    }
  }
  
	public function admin()
	{
    if($this->session->userdata('logged_in') && $this->dbmodel->isAdmin($this->session->userdata("user"))){

      if($this->input->post("formsent", TRUE)){ //itt az XSS check elhagyható
        //ha el lett küldve a form!
        if($this->input->post("freereg", TRUE)){ //checkbox bepipálva
          $this->dbmodel->regToggle(true);
        }else{ //chekcbox üres
          $this->dbmodel->regToggle(false);
        }
        $data["successmsg"] = "Sikeres adatmódosítás!";
      }
      
      $data["freereg"] = $this->dbmodel->checkRegEnabled(); //ellenőrzésnek a DB-ből kérjük
      
      $this->load->view('header');
      $this->load->view('menu');
      $this->load->view('content_admin', $data);
      $this->load->view('footer');
    }else{
      redirect("main/index");
    }
	}
  
  public function registration(){
      if($this->session->userdata('logged_in')){ //ha mar be van lepve, dobja az indexre
        redirect("main/index");
      }
      
      $data["allowedReg"] = $this->dbmodel->checkRegEnabled();
      
      if($data["allowedReg"]){ //regisztracio nincs kikapcsolva
        $user = $this->input->post("user", TRUE);
        $email = $this->input->post("email", TRUE);
        $pass1 = $this->input->post("pass1", TRUE);
        $pass2 = $this->input->post("pass2", TRUE);
        
        if(empty($user) || empty($email) || empty($pass1) || empty($pass2)){
          $data["errormsg"] = "Minden adat kitöltése kötelező";
        }else{
          if($pass1 == $pass2){
            $pass = sha1($pass1);
            if($this->dbmodel->checkUser($user)){
              if($this->dbmodel->checkEmail($email)){
                $this->dbmodel->newReg($user, $email, $pass);
                $data["successmsg"] = "Sikeres regisztráció!";
              }else{
                $data["errormsg"] = "Az e-mail cím már használatban van!";
              }
            }else{
              $data["errormsg"] = "A felhasználónév már használatban van!";
            }
          }else{
            $data["errormsg"] = "A két jelszó nem egyezik!";
          }
        }
        
        $data["user"] = $user;
        $data["email"] = $email;
      }
      
      //ha nincs reg. rengedve, akkor is atmeggy az "allowedReg" false-al
      $this->load->view('header');
      $this->load->view('content_registration', $data);
      $this->load->view('footer');
  }
  
  public function details($id = false, $page = 0){
    if($id && $this->session->userdata('logged_in')){
      $inurl = $this->input->post("inurl", TRUE);
      $data["inurl"] = $inurl;
      $data["runtime"] = $this->input->post("runtime", TRUE);
      $data["sendemail"] = $this->input->post("sendemail", TRUE) ? 1 : 0;
      $data["repeat"] = $this->input->post("repeat", TRUE);
      if($this->input->post("sendform", TRUE)){
        if($inurl){
          //TODO kódolás
          $stamp = strtotime($this->input->post("runtime", TRUE));
          if($stamp && $stamp > time()-60){
          #if($stamp && $stamp != -1 && $stamp > time()-60){
            //regen -1 volt 5.1.0 elott + ellenorizzuk, hogy nagyobb legyen az aktualis datumnal, kis ráhagyással (1 perc)
            
            //print "OK";
            //print $stamp." -> ".date("Y-m-d H:i", $stamp);
            
            if(preg_match("/^(http|https):\/\//", $inurl)){
              if(preg_match($this->ext_regex, $inurl)){

                if(!is_numeric($data["repeat"])){ //ha hamis vagy nem szám, akkor nullázzuk
                  $data["repeat"] = 0;
                }else{
                  $data["repeat"] = $data["repeat"] * 86400; //24 * 60 * 60 = 86400 másodpercre váltjuk
                }
                
                $olddata = $this->dbmodel->getProcessDataById($id, $this->dbmodel->getUidByUser($this->session->userdata('user')));
                
                
                if($stamp  != $olddata['runtime'] || $data["repeat"] != $olddata['repeat']){ 
                  //ha megváltozott az időpont vagy az ismétlődés
                  $this->dbmodel->updateProcess($id, $this->dbmodel->getUidByUser($this->session->userdata('user')),
                  array('url' => $inurl, 'state' => 0, 'runtime' => $stamp, 'sendmail' => $data["sendemail"], 'repeat' => $data["repeat"]));
                  $data["successmsg"] = "Sikeres időpont frissítés!";
                  /**
                    Az időpontban benne van már az ismétlés ideje!
                    Ha változtatják, lekük rajta, akkor az új időpont lesz a lényeges, itt úgyis csak frissebbet lehet betenni -> Várakozik állapot kell.
                    
                    Ha az ütemezés változik -> akkor szintén állapot frissítés kell, de a dátum is nagyobb kell legyen -> nincs gond!
                    VAGYIS: Az új futtatási időpont MINIDG nagyobb kell legyen, mint az aktuális időpont -> sok ellenőrzést meg lehet spróolni
                  */
                  
                  
                }else{
                  $this->dbmodel->updateProcess($id, $this->dbmodel->getUidByUser($this->session->userdata('user')),
                  array('url' => $inurl, 'sendmail' => $data["sendemail"]));
                  $data["successmsg"] = "Sikeres frissítés!";
                }
                
                //$data["inurl"] = "";
                //$data["runtime"] = "";
              }else{
                $data["errormsg"] = "Az URL-nek .htm, .html, .php, .asp vagy .xml-re kell végződnie.";
              }
            }else{
              $data["errormsg"] = "Az URL-nek http-vel vagy https-el kell kezdődnie!";
            }
          }else{
            $data["errormsg"] = "Rossz dátum formázás vagy érvénytelen időpont.";
          }
        }else{
          $data["errormsg"] = "Ki kell tölteni az URL mezőt!";
        }
      }
      
      //oldalakra tördelés
      $this->load->library('pagination');
      $conf['base_url'] = site_url('main/details/'.$id);
      $conf['total_rows'] = $this->dbmodel->countPageDataById($id, $this->dbmodel->getUidByUser($this->session->userdata('user')));
      $conf['per_page'] = 4; //oldalanként hányat mutat
      $conf['uri_segment'] = 4;
      $this->pagination->initialize($conf);

      $data["datalist"] = $this->dbmodel->getProcessDataById($id, $this->dbmodel->getUidByUser($this->session->userdata('user')));
      $data["pages"] = $this->dbmodel->getPageDataByIdLimit($id, $this->dbmodel->getUidByUser($this->session->userdata('user')), $page, $conf['per_page']);
      
      $this->load->view('header');
      $this->load->view('menu');
      $this->load->view('content_procdetails', $data);
      $this->load->view('footer');
    }else{
      redirect("main/index");
    }
  }
  
  public function delproc($id = false){
    if($id && $this->session->userdata('logged_in')){
      $this->dbmodel->delProcess($id, $this->dbmodel->getUidByUser($this->session->userdata('user')));
      redirect("main/index");
    }else{
      redirect("main/index");
    }
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
