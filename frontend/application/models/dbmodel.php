<?php

class Dbmodel extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    function checkRegEnabled(){
      return true; //TODO: Lekérés generálás hozzá
    }
    
    function checkLogin($user, $pass){
      $this->db->where("user", $user);
      $this->db->where("pass", $pass);
      $q = $this->db->get("users");
      if($q->num_rows() == 1){
        return true;
      }else{
        return false;
      }
    }

}