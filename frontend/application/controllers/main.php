<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {


	public function index()
	{
    if($this->session->userdata('logged_in')){
    
      $this->load->view('header');
      $this->load->view('menu');
      //TODO: tartalom
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
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */