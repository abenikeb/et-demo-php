<?php
  require_once('./service/createOrderService.php');
  require_once('./config/env.php');

  header('content-type:application/json');
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: *");
  header("Access-Control-Allow-Methods: PUT, GET, POST");
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

  $METHOD = $_SERVER['REQUEST_METHOD'];
  $ROUTE = $_SERVER['REQUEST_URI'];
  // print_r($METHOD);
  // print_r($ROUTE);
  $REQUEST_PARAMS = json_decode(file_get_contents('php://input'));

  print_r();
  $createOrderService = new CreateOrderService(
                      $baseUrl=$ENV_Variables['baseUrl'], 
                      $req=$REQUEST_PARAMS, 
                      $fabricAppId=$ENV_Variables['fabricAppId'], 
                      $appSecret=$ENV_Variables['appSecret'], 
                      $merchantAppId=$ENV_Variables['merchantAppId'], 
                      $merchantCode=$ENV_Variables['merchantCode']);

  switch($METHOD){ 
    case 'POST':
<<<<<<< HEAD
      if($ROUTE == '/et-demo-php/create/order'){
        // $newSupport = $createOrderService->createOrder();
        $new = ['raw_request', 'rrr'];
        return $new;

      } else if($ROUTE == "/et-demo-php/auth/token"){
=======
      if($ROUTE == "/et-demo-php-recover/create/order"){
        $createOrderService->createOrder();
      } else if($ROUTE == "et-demo-php-recover/auth/token"){
>>>>>>> 61641f1f5d0c8ea3d362de40ee3a642739a8486b
        applyFabricToken($REQUEST_PARAMS);
      }
      break;

    default:
      echo "WELCOME TO PAYMENT PAGE!";
      exit;
  }

  ?>