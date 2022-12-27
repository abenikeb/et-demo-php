
<?php 

require_once('./vendor/autoload.php') ;

function sign($ussd, $app_key) {   
        $data = $ussd;               
        ksort($data);
        $stringApplet = '';         
        foreach ($data as $key => $values) { 
            
            if($key !== "biz_content"){
                if ($stringApplet == '') {       
                    $stringApplet = $key . '=' . $values; 
                } else {                              
                    $stringApplet = $stringApplet . '&' . $key . '=' . $values;            
                } 
            }
            else if($key == "biz_content"){
                foreach($values as $value => $single_value){
                    if ($stringApplet == '') {     
                        $stringApplet = $value . '=' . $single_value;           
                    } else {                
                        $stringApplet = $stringApplet . '&' . $value . '=' . $single_value;            
                    }  
                }
            } 
        }

    return getRSAKeys(sortedString($stringApplet)); 
    }

function sortedString($stringApplet){
    $stringExplode = '';
    $sortedArray = explode("&",$stringApplet);
    sort($sortedArray);
    foreach($sortedArray as $x => $x_value) {
    if ($stringExplode == '') {     
            $stringExplode = $x_value;           
        } else {                
            $stringExplode = $stringExplode . '&' . $x_value;            
        }  
    }

    return $stringExplode;
    // $stingAqured = 'appid=850259476582401&merch_code=100000108&merch_order_id=1672160113687&method=payment.preorder&nonce_str=A2Y0OMG8E9H8TM5F45WR1V8VY78G6O5U&notify_url=https://www.google.com&timeout_express=120m&timestamp=1672160114&title=diamond_100&total_amount=100&trade_type=InApp&trans_currency=USD&version=1.0';
}

function getRSAKeys($data){
        
    $private_key = <<<EOD
    -----BEGIN RSA PRIVATE KEY-----
    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
    -----END RSA PRIVATE KEY-----
    EOD;

    $binary_signature = "";

    $algo = "sha256WithRSAEncryption";

    openssl_sign($data, $binary_signature, $private_key, $algo);
    
    $signature = base64_encode($binary_signature);

    return $signature;   

}

function newGetRSA($plainData){
    // Create test key
    $newKeyPair = getRSAKeys();
    $privateKey = $newKeyPair[0];
    $publicKey = $newKeyPair[1];

    // Test 1: openssl_private_encrypt and openssl_verify
    $dataToSign = $plainData; // Could correspond to e.g. json_encode($result) in the code
    $dataToSignHashed = hash('sha256', $dataToSign, true);
    $dataToSignHashedWithID = hex2bin("3031300d060960864801650304020105000420") . $dataToSignHashed; // ID from https://www.rfc-editor.org/rfc/rfc8017#page-47
    openssl_private_encrypt($dataToSignHashed, $signature, $privateKey, OPENSSL_PKCS1_PADDING);
    // $verified = openssl_verify($dataToSign, $signature, $publicKey, OPENSSL_ALGO_SHA256);
    // print($verified) . PHP_EOL;
    return base64_encode($signature);
}

function encrypt_RSA($plainData){

    $ENCRYPT_BLOCK_SIZE = 200;// this for 2048 bit key for example, leaving some room

    // //Block size for decryption block cipher
    $DECRYPT_BLOCK_SIZE = 256;// this again for 2048 bit key

    $encrypted = '';
        
}

function applySHA256Encription($req){

    $app_key="9e0ff359-582c-4677-b07d-dbe3a4dc24ea";

    return sign($req, $app_key);

}

function createTimeStamp() {
  return (string)round(time());
}

// create a 32 length random string
function createNonceStr() {
  $chars = [
    "0",
    "1",
    "2",
    "3",
    "4",
    "5",
    "6",
    "7",
    "8",
    "9",
    "A",
    "B",
    "C",
    "D",
    "E",
    "F",
    "G",
    "H",
    "I",
    "J",
    "K",
    "L",
    "M",
    "N",
    "O",
    "P",
    "Q",
    "R",
    "S",
    "T",
    "U",
    "V",
    "W",
    "X",
    "Y",
    "Z",
  ];
  $str = "";
  for ($i = 0; $i < 32; $i++) {
    // $index = parseInt(Math.random() * 35);
    $index = intval(rand() * 35);
    // print_r($index);
    $str .= $chars[$i];
  }
  return "5K8264pLTKCH16CQ2502nI8zNMTM6790";
}


