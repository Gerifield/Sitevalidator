<?php

class Dbmodel extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    function checkRegEnabled(){
      return true; //TODO: Lek�r�s gener�l�s hozz�
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