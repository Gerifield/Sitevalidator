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
    
    
  
		$this->load->view('header');
    $this->load->view('content_login', $data);
    $this->load->view('footer');
  }
  
    public function logout(){
        $this->session->set_userdata("logged_in", false);
        $this->session->sess_destroy();
        redirect("main/index");
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */