<?php
  // require_once('startUp.php');
  require_once('./service/createOrderService.php');

  header('content-type:application/json');
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: *");
  header("Access-Control-Allow-Methods: PUT, GET, POST");
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

  $METHOD = $_SERVER['REQUEST_METHOD'];
  $ROUTE = $_SERVER['REQUEST_URI'];
  $REQUEST_PARAMS = json_decode(file_get_contents('php://input'));

  $createOrderService = new CreateOrderService(
                      $baseUrl="http://119.13.109.189:8090/apiaccess/payment/gateway", 
                      $req=$REQUEST_PARAMS, 
                      $fabricAppId="9e0ff359-582c-4677-b07d-dbe3a4dc24ea", 
                      $appSecret="851bdccee2f83722658a45e3ddc4017a", 
                      $merchantAppId="850259476582401", 
                      $merchantCode="100000108");


switch($METHOD){ 
  case 'POST':
    if($ROUTE == "/et-demo-php/create/order"){
      $createOrderService->createOrder();
    } else if($ROUTE == "/et-demo-php/auth/token"){
      applyFabricToken($REQUEST_PARAMS);
    }
    break;

  default:
    echo "WELCOME TO PAYMENT PAGE!";
    exit;
}