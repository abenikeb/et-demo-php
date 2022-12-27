<?php

require_once('./service/createOrderService.php');
require_once('./service/applyFabricTokenService.php');

class SERVICE {
  public $req;
  public $method;
  public $route;


  function __construct($req, $method, $route) {
  $this->req = $req; 
  $this->method = $method; 
  $this->route = $route; 
    
  header('content-type:application/json');
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Methods: *");

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: PUT, GET, POST");
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

  }
  
  function START_UP(){

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    // $method = $_SERVER['REQUEST_METHOD'];
    // $route = $_SERVER['REQUEST_URI'];

    // print_r($method);
    // print_r($route);

    switch($this->method){
      
      case 'POST':
        if($this->$route == "/create/order"){
        //   $req = json_decode(file_get_contents('php://input'));
          createOrder($this->req);
        } else if($this->route == "/auth/token"){
        //   $req = json_decode(file_get_contents('php://input'));
          applyFabricToken($this->req);
        }
        break;

      default:
        print_r('WELCOME TO HOME PAGE');

    }

}

}




// SERVICE();