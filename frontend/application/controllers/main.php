<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {


	public function index()
	{
    if($this->session->userdata('logged_in')){
    
      $this->load->view('header');
      $this->load->view('menu');
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
    
    public function profil(){
      
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */