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
    
    function isAdmin($user){
      $this->db->select("isadmin");
      $this->db->where("user", $user);
      $q = $this->db->get("users");
      $row = $q->row_array();
      if(isset($row["isadmin"])){
        return ($row["isadmin"]==1) ? true : false; #1 eset�n igaz
      }else{
        return false;
      }
    }
    
    function getUserData($user){
      $this->db->where("user", $user);
      $q = $this->db->get("users");
      return $q->row_array();
    }
    
    function updatePass($user, $pass){ #passt titkositani!
      $this->db->where("user", $user);
      $this->db->update("users", array('pass' => $pass) );
    }
    function updateEmail($user, $email){ #passt titkositani!
      $this->db->where("user", $user);
      $this->db->update("users", array('email' => $email) );
    }
}