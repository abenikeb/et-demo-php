
<?php 

class ApplySHA256Encription {



Public function applySHA256Encription($req){

// $req = array('timestamp' => "TTT", 
//              'nonce_str' => "NNN",
//              'method' => "payment.preorder",
//              'version' => '1.0',
//              'biz_content' => []
//              );

// $biz = array('notify_url' => 'https://www.google.com' , 
//              'trade_type' => "InApp",
//              'appid' => "12322323",
//              'merch_code' => '1.0',
//              'merch_order_id' => 'https://www.google.com' , 
//              'title' => "InApp",
//              'total_amount' => "12",
//              'trans_currency' => '1.0',
//              'timeout_express' => '1.0'
//               );

// $req['biz_content'] = $biz;

$app_key="7ca6ef17-df90-45a9-a589-62ea3d94d3fb";

$newSign  =  _sign($req, $app_key);

$private_key = <<<EOD
-----BEGIN PUBLIC KEY-----
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
-----END PUBLIC KEY-----
EOD;
sha256WithRSAEncryption($newSign);

// print_r($newSign);
function _sign($ussd, $app_key)    
{   
    // print_r($ussd);   
    $data = $ussd;        
    $data['appKey'] = $app_key;        
    ksort($data);
    $StringA = "";   
    $StringB = "";       
        
foreach ($data as $k => $v) {   
    if($k == "biz_content"){
        foreach($v as $rr => $rrr){
             if ($StringA == '') {     
                $StringA = $rr . '=' . $rrr;           
            } else {                
                $StringA = $StringA . '&' . $rr . '=' . $rrr;            
            }  
        }
    }
   
    if($k !== "biz_content") {
         if ($StringA == '') {       
            $StringA = $k . '=' . $v;           
        } else {                
            $StringA = $StringA . '&' . $k . '=' . $v;            
        }   

    }       
}
//  print_r($StringA);          
    // return hash("sha256", $StringA);
    return $StringA;
}

function encryptRSA($data, $public)    {        
    $pubPem = chunk_split($public, 64, "\n");        
    $pubPem = "-----BEGIN PUBLIC KEY-----\n" . $pubPem . "-----END PUBLIC KEY-----\n";        
    $public_key = openssl_pkey_get_public($pubPem);       
    if (!$public_key) {            
        die('invalid public key');        
    }        
    $crypto = '';        
    foreach (str_split($data, 117) as $chunk) {            
        $return = openssl_public_encrypt($chunk, $cryptoItem, $public_key);            
        if (!$return) {                
            return ('fail');           
         }            
        $crypto .= $cryptoItem;        
    }        
    $ussd = base64_encode($crypto);        
    return $ussd;   
 }

 function sha256WithRSAEncryption($data){
    $private_key = <<<EOD
    -----BEGIN RSA PRIVATE KEY-----
    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
    -----END RSA PRIVATE KEY-----
    EOD;

    $binary_signature = "";

    $algo = "sha256WithRSAEncryption";

    openssl_sign($data, $binary_signature, $private_key, $algo);
    $signature = base64_encode($binary_signature);
    echo $timestamp = time();
    echo "<br>";
    print_r($signature);
 }

}

}