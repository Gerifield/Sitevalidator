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
    
    function getShortProcessDataByUid($uid){
      $this->db->order_by("id", "asc"); 
      $this->db->where("uid", $uid);
      $q = $this->db->get("processes");
      $result = array(); // ha �res lenne a lek�r�s
      foreach($q->result_array() as $row){
        //B�r l�tv�nyosabb, de t�k f�l�sleges....
        //array_push( $result, array('id' => $row['id'], 'url' => $row['url'], 'state' => $row['state'],
        //'runtime' => $row['runtime'], 'starttime' => $row['starttime'], 'htmlvalidity' => $row['htmlvalidity'], 'cssvalidity' => $row['cssvalidity']));
        array_push($result, $row);
      }
      return $result; // Forma: [id => [adatok], id => [adatok]]
    }
    function getProcessDataById($id, $uid){ //az �tadott UID-b�l "tudja", hogy el�rhet�-e
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
      $this->db->insert("processes", array('token' => sha1($uid.$url.rand()), 'url' => $url, 'runtime' => $runtime, 'uid' => $uid));
    }
    
    function updateProcess($id, $uid, $params){ //UID-vel is azonos�t, csak saj�tot �rhat fel�l
      $this->db->where("id", $id);
      $this->db->where("uid", $uid);
      $this->db->update("processes", $params );
      //array('url' => $url, 'runtime' => $runtime));
    }
    
    function delProcess($id, $uid){ //az UID-vel ellen�rizhet�, hogy a saj�tja-e
      $this->db->delete("page_data", array('pid' => $id, 'uid' => $uid)); //az�rt, hogy csak a saj�t pid-� bejegyz�st tudja csak t�r�lni
      $this->db->delete("processes", array('id' => $id, 'uid' => $uid));
    }
    
    function updateProcessResults($token, $resultArray){
      $this->db->where("token", $token);
      $this->db->update("processes", $resultArray);
    }
    
    function getProcIdByToken($token){
      $this->db->where("token", $token);
      $q = $this->db->get("processes");
      $ret = $q->row_array();
      return $ret["id"];
    }
    function getProcDataByToken($token){
      $this->db->where("token", $token);
      $q = $this->db->get("processes");
      return $q->row_array();
    }
    
    function addPageData($data){
      $this->db->insert("page_data", $data);
    }
    
    function delPageData($pid, $uid){
      $this->db->delete("page_data", array('pid' => $pid, 'uid' => $uid));
    }
    
    function getPageDataById($pid, $uid){
      $this->db->where("pid", $pid);
      $this->db->where("uid", $uid);
      $q = $this->db->get("page_data");
      $result = array(); // ha �res lenne a lek�r�s
      foreach($q->result_array() as $row){
        //array_push( $result, array('pid' => $row['pid'], 'uid' => $row['uid'], 'url' => $row['url'], 'code' => $row['code'], 'runtime' => $row['runtime'],
        //'htmlvalidity' => $row['htmlvalidity'], 'htmldoctype' => $row['htmldoctype'], 'htmlerrornum' => $row['htmlerrornum'], 'htmlwarningnum' => $row['htmlwarningnum'],
        //'cssvalidity' => $row['cssvalidity'], 'cssdoctype' => $row['cssdoctype'], 'csserrornum' => $row['csserrornum'], 'csswarningnum' => $row['csswarningnum'] ));
        array_push($result, $row);
      }
      return $result;
    }
    function getPageDataByIdLimit($pid, $uid, $from, $num){
      $this->db->where("pid", $pid);
      $this->db->where("uid", $uid);
      $this->db->limit($num, $from);
      $q = $this->db->get("page_data");
      $result = array(); // ha �res lenne a lek�r�s
      foreach($q->result_array() as $row){
        array_push($result, $row);
      }
      return $result;
    }
    function countPageDataById($pid, $uid){
      $this->db->where("pid", $pid);
      $this->db->where("uid", $uid);
      $q = $this->db->get("page_data");
      return $q->num_rows();
    }
}