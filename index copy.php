<?php

  require_once('startUp.php');
  require_once('./service/createOrderService.php');

  // $method = $_SERVER['REQUEST_METHOD'];
  // $route = $_SERVER['REQUEST_URI'];

  // $req = json_decode(file_get_contents('php://input'));

  // $newService = new SERVICE($req, $method, $route);
  // $newService->START_UP();

  //  public $req;
  //   public $fabricAppId;
  //   public $appSecret;
  //   public $merchantAppId;
  //   public $merchantCode;
  $newVariable = new CreateOrderService($baseUrl="http://119.13.109.189:8090/apiaccess/payment/gateway", 
                                        $req=" ", 
                                        $fabricAppId="9e0ff359-582c-4677-b07d-dbe3a4dc24ea", 
                                        $appSecret="851bdccee2f83722658a45e3ddc4017a", 
                                        $merchantAppId="850259476582401", 
                                        $merchantCode="100000108");
  $newVariable->createOrder();
 
  // print_r($method);
  // print_r($route);

  // switch($method){
    
  //   case 'POST':
  //     if($route == "/create/order"){
  //       createOrder($req);
  //     } else if($route == "/auth/token"){
  //       $req = json_decode(file_get_contents('php://input'));
  //       applyFabricToken($req);
  //     }
  //     break;

  //   default:
  //     print_r('WELCOME TO HOME PAGE');

