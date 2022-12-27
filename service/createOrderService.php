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
        // $title = $req->body->title;
        // $amount = $req->body->amount;
        $title = "Ipone";
        $amount = "10";
    
        $applyFabricTokenResult = new ApplyFabricToken($this->BASE_URL, 
                                                       $this->fabricAppId, 
                                                       $this->appSecret, 
                                                       $this->merchantAppId  );
        $res = json_decode($applyFabricTokenResult->applyFabricToken());
        $fabricToken = $res->token;

        // print_r($fabricToken);
        $createOrderResult = $this->requestCreateOrder($fabricToken, $title, $amount);
    
        print_r($createOrderResult);
    
        // $prepayId = $createOrderResult->biz_content->prepay_id;
        // $rawRequest = createRawRequest($prepayId);
    
        // if($rawRequest) {
        //     $response = ['status' => 1, 'message' => 'Record created successfully.', 'res' => $rawRequest];
        // } else {
        //     $response = ['status' => 0, 'message' => 'Failed to create record.'];
        // }
        // echo json_encode($response);
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
                // 'nonce_str' => createNonceStr(),
                'timestamp' => '1672147787', 
                'nonce_str' => 'BJXP5NE5HFLUHK32V8HC8X3UNBC7GFXT',
                'method' => 'payment.preorder',
                // 'timestamp' => createTimeStamp(), 
                'version' => '1.0',
                'biz_content' => [],
                );
    
        $biz = array( 'notify_url' => 'https://www.google.com', 
                    'trade_type' => 'InApp',
                    // 'appid' => $this->merchantAppId,
                     'appid' => '850259476582401',
                    // 'merch_code' => $this->merchantCode,
                    'merch_code' => '100000108',
                    // 'merch_order_id' => $this->createMerchantOrderId(), 
                    'merch_order_id' => '1672147786909', 
                    'title' => 'diamond_100',
                    'total_amount' => '100',
                    'trans_currency' => 'USD',
                    'timeout_express' => '120m'
                    // "business_type" => "P2PTransfer",
                    // "payee_identifier" => "MerchantConfigure",
                    // "payee_identifier_type" => "01",
                    // "payee_type" => "1000"
                    );
    
        $req['biz_content'] = $biz;
        // $req['sign'] = 'c9xcQa4CUWqWZOwUKk0AK550TKpGlG3ycuSL+TvSgtUjr5eyMK0erBKbkPyqYzXwAeorHH/ZEbEbP3ld5O6rNFQIown2YHKA9zllAkdqaaqH/IqcSuQjVFeIerhC5Jk7cJxqSohEk6tSUseDd+sqRQVQ1n4AIX0ffOkydpFmvWrs7rY4YtCHX6Wu+xBqo4oEcKU56cMdpNnfetaqugqo9QJeCTD1s1+bjf0obaFtCfC1QVayjdu+CKYUnyc/xOFcug3Nlhu2nnF+TqkoQbu1yW9HjflAelOWA+pOcF0cjoEM66yt9oTtRkRVfKNMe+DF+wKb4m9IOkrkuabh7LLfbJPloBERgLhRCLrwK8yDK0zE0o6VrpFZ1DXa/b4grviSrx9n3yN9XvnGDqZDe2bTM30AsNNtlR7aBg4sGwfWuEVLwsmoR/QweOuydxV3NA2h0j+xvbaJ3E7h+dCGwqARtDtZBzSQOlYiTcfHcIWdbZkCtbMHs+AjkuvBmBsM/+YH';
        $req['sign'] = applySHA256Encription($req);
        $req['sign_type'] = 'SHA256WithRSA';

        print_r(json_encode($req));
     
    return json_encode($req);
    }
    
    
    // create a rawRequest string for H5 page to start pay
    function createRawRequest($prepayId) {
        $map =array(
            "appid" => "850259476582401",
            "merch_code" => "100000108",
            "nonce_str" => "5K8264ILTKCH16CQ2502SI8ZNMTM67VS",
            "timestamp" => (string)time(), 
            );
    
      $sign = applySHA256Encription($req);
      // order by ascii in array
      $rawRequest = 
        "appid=" . $map['appid'] . '&' .
        "merch_code=" + $map['merch_code'] . '&' .
        "nonce_str=" + $map['nonce_str'] . '&' .
        "prepay_id=" + $map['prepay_id'] . '&' .
        "timestamp=" + $map['timestamp'] . '&' .
        "sign=" + $sign . '&' .
        "sign_type=SHA256WithRSA";
    
      return $rawRequest;
    }

}




// var_dump($server_output);