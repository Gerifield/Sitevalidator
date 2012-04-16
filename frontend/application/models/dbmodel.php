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
    
    function getUidByUser($user){
      $this->db->where("user", $user);
      $q = $this->db->get("users");
      $ret = $q->row_array();
      return $ret["id"];
    }
    function getUserByUid($uid){
      $this->db->where("id", $uid);
      $q = $this->db->get("users");
      $ret = $q->row_array();
      return $ret["user"];
    }
    
    function getAllProcessDataByUid($uid){
      $this->db->order_by("id", "asc"); 
      $this->db->where("uid", $uid);
      $q = $this->db->get("processes");
      $result = array(); // ha üres lenne a lekérés
      foreach($q->result_array() as $row){
        array_push( $result, array('id' => $row['id'], 'url' => $row['url'], 'state' => $row['state'], 'runtime' => $row['runtime'],
        'htmlvalidity' => $row['htmlvalidity'], 'htmldoctype' => $row['htmldoctype'], 'htmlerrornum' => $row['htmlerrornum'], 'htmlwarningnum' => $row['htmlwarningnum'],
        'cssvalidity' => $row['cssvalidity'], 'cssdoctype' => $row['cssdoctype'], 'csserrornum' => $row['csserrornum'], 'csswarningnum' => $row['csswarningnum']) );
      }
      return $result; // Forma: [id => [adatok], id => [adatok]]
    }
    function getShortProcessDataByUid($uid){
      $this->db->order_by("id", "asc"); 
      $this->db->where("uid", $uid);
      $q = $this->db->get("processes");
      $result = array(); // ha üres lenne a lekérés
      foreach($q->result_array() as $row){
        array_push( $result, array('id' => $row['id'], 'url' => $row['url'], 'state' => $row['state'], 'runtime' => $row['runtime'],
        'htmlvalidity' => $row['htmlvalidity'], 'cssvalidity' => $row['cssvalidity']));
      }
      return $result; // Forma: [id => [adatok], id => [adatok]]
    }
    function getProcessDataById($id, $uid){ //az átadott UID-bõl "tudja", hogy elérhetõ-e
      $this->db->where("id", $id);
      $this->db->where("uid", $uid);
      $q = $this->db->get("processes");
      if($q->num_rows() > 0){
        return $q->row_array();
      }else{
        return false;
      }
    }
    
    function addNewProcess($url, $runtime, $uid){
      $this->db->insert("processes", array('token' => sha1($uid.$url.$runtime), 'url' => $url, 'runtime' => $runtime, 'uid' => $uid));
    }
    
    function updateProcess($id, $url, $runtime, $uid){ //UID-vel is azonosít, csak sajátot írhat felül
      $this->db->where("id", $id);
      $this->db->where("uid", $uid);
      $this->db->update("processes", array('url' => $url, 'runtime' => $runtime));
    }
    
    function delProcess($id, $uid){ //az UID-vel ellenõrizhetõ, hogy a sajátja-e
      $this->db->delete("processes", array('id' => $id, 'uid' => $uid));
    }
}