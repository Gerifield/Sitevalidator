<?php

class Dbmodel extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    function checkRegEnabled(){
      $this->db->where("data", "registration");
      $q = $this->db->get("page_config");
      $row = $q->row_array();
      if($row["value"] == 1){
        return true;
      }else{
        return false;
      }
    }
    function regToggle($value){ //true/false
      $this->db->where("data", "registration");
      if($value){ //ha igaz, engedelyezi
        $this->db->update("page_config", array('value' => '1') );
      }else{
        $this->db->update("page_config", array('value' => '0') );
      }
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
        return ($row["isadmin"]==1) ? true : false; #1 esetén igaz
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
    
    function checkUser($user){
      $this->db->where("user", $user);
      $q = $this->db->get("users");
      if($q->num_rows() == 0){
        return true;
      }else{
        return false;
      }
    }
    
    function checkEmail($email){
      $this->db->where("email", $email);
      $q = $this->db->get("users");
      if($q->num_rows() == 0){
        return true;
      }else{
        return false;
      }
    }
    
    function newReg($user, $email, $pass){
      $this->db->insert("users", array("user" => $user, "email" => $email, "pass" => $pass) );
    }
}