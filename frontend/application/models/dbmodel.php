<?php

class Dbmodel extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    function checkRegEnabled(){
      return true; //TODO: Lekérés generálás hozzá
    }

}