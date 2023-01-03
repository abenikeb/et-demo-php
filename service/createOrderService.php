<?php

require_once('applyFabricTokenService.php');
require_once('./utils/tool.php');
require_once('./config/env.php');

class CreateOrderService{

    public $BASE_URL;
    public $req;
    public $fabricAppId;
    public $appSecret;
    public $merchantAppId;
    public $merchantCode;

    function __construct($baseUrl, $req, $fabricAppId, $appSecret, $merchantAppId, $merchantCode) {
        $this->BASE_URL = $baseUrl;
        $this->req = $req;
        $this->fabricAppId = $fabricAppId;
        $this->appSecret = $appSecret;
        $this->merchantAppId = $merchantAppId;
        $this->merchantCode = $merchantCode;
    }

    function createOrder(){
        $title = $this->req->title;
        $amount = $this->req->amount;

        $applyFabricTokenResult = new ApplyFabricToken(
                                    $this->BASE_URL, 
                                    $this->fabricAppId, 
                                    $this->appSecret, 
                                    $this->merchantAppId  
                                );
        $res = json_decode($applyFabricTokenResult->applyFabricToken());

        $fabricToken = $res->token;

        $createOrderResult = $this->requestCreateOrder($fabricToken, $title, $amount);
    
        $prepayId = json_decode($createOrderResult)->biz_content->prepay_id;

        $rawRequest = $this->createRawRequest($prepayId);
        
        if($rawRequest) {
            $response = [ 'rawRequest' => $rawRequest];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        return $rawRequest;
    }
    
    function requestCreateOrder($fabricToken, $title, $amount) {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $this->BASE_URL.'/payment/v1/merchant/preOrder');
       curl_setopt($ch, CURLOPT_POST, 1);
       
       // Header parameters
        $headers = array(
            "Content-Type: application/json",
            "X-APP-Key: ".$this->fabricAppId ,
            "Authorization: " .$fabricToken
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        // Body parameters
        $payload = $this->createRequestObject($title, $amount);
    
        $data = $payload;
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $server_output = curl_exec($ch);
    
        curl_close ($ch);
       
        return $server_output;
    
    }

    function createMerchantOrderId() {
        return (string)time();
    }
       
    function createRequestObject($title, $amount) {
        $req = array(
                'nonce_str' => createNonceStr(),
                'nonce_str' => 'A2Y0OMG8E9H8TM5F45WR1V8VY78G6O5U',
                'method' => 'payment.preorder',
                'timestamp' => createTimeStamp(), 
                'version' => '1.0',
                'biz_content' => [],
                );
    
        $biz = array( 'notify_url' => 'https://www.google.com', 
                      'trade_type' => 'InApp',
                      'appid' => $this->merchantAppId,
                      'merch_code' => $this->merchantCode,
                      'merch_order_id' => $this->createMerchantOrderId(),
                      'title' => $title,
                      'total_amount' => $amount,
                      'trans_currency' => 'USD',
                      'timeout_express' => '120m'
                    );
    
        $req['biz_content'] = $biz;
        $req['sign'] = applySHA256Encription($req);
        $req['sign_type'] = 'SHA256WithRSA';
     
      return json_encode($req);
    }  
    
    // create a rawRequest string for H5 page to start pay
    function createRawRequest($prepayId) {
        $maps =array(
            "appid" => $this->merchantAppId,
            "merch_code" => $this->merchantCode,
            "nonce_str" => createNonceStr(),
            "prepay_id" => $prepayId,
            "timestamp" => (string)time() 
            );
        
        $sign = applySHA256Encription($maps);

        $rawRequest = '';
        // order by ascii in array
        foreach($maps as $map => $m){
                if ($rawRequest == '') {     
                    $rawRequest = $map . '=' . $m;           
                } else {                
                    $rawRequest = $rawRequest . '&' . $map . '=' . $m;            
                }  
            }
        
        $rawRequest = $rawRequest . '&' . 'sign=' . $sign;
        return $rawRequest;
    }

}
