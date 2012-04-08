<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {


	public function index()
	{
    if($this->session->userdata('logged_in')){
      
      $inurl = $this->input->post("add_url", TRUE);
      if($inurl){
        //TODO kódolás
      }
      $data["datalist"] = ""; //TODO: Lekérdezés
      
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
        $data["errormsg"] = "Hibás felhasznűló név vagy jelszó!";
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
        $this->dbmodel->updateEmail($this->session->userdata("user"), $email);
        if(!isset($data["successmsg"])){ //ha nem módosult a jelszó, akkor írjuk ezt ki (vagyis mindig, amikor a formot elkuldik)
          $data["successmsg"] = "Sikeres e-mail módosítás!";
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
              $data["errormsg"] = "A felhasználó név már használatban van!";
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
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */