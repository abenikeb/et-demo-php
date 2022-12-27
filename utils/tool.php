
<?php 

require_once('./vendor/autoload.php') ;

// $key = openssl_pkey_get_public("file://private_key.pem");


// print_r($key);

use phpseclib3\Crypt\PublicKeyLoader;

// PrivateKey loadPrivateKey(file_get_contents('private_key.pem'), $password = '');
// include('Crypt/RSA.php');



function sign($ussd, $app_key)    
{   
    $data = $ussd;        
    // $data['appKey'] = $app_key;        
    ksort($data);
    $StringA = "";         
    foreach ($data as $key => $values) { 
          
        if($key !== "biz_content"){
            if ($StringA == "") {       
                $StringA = $key . '=' . $values; 
            } else {                              
                $StringA = $StringA . '&' . $key . '=' . $values;            
            } 
        }
        else if($key == "biz_content"){
            foreach($values as $value => $single_value){
                if ($StringA == "") {     
                    $StringA = $value . '=' . $single_value;           
                } else {                
                    $StringA = $StringA . '&' . $value . '=' . $single_value;            
                }  
            }
        } 
    }

    //    $private_key = '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';


// $new_key_pair = openssl_pkey_new(array(
// "private_key_bits" => 2048,
// "private_key_type" => OPENSSL_KEYTYPE_RSA,
// ));
// openssl_pkey_export($new_key_pair, $private_key_pem);

// $details = openssl_pkey_get_details($new_key_pair);
// $public_key_pem = $details['key'];

// openssl_sign($StringA, $signature, $private_key, OPENSSL_ALGO_SHA256);

// //save for later
// file_put_contents('private_key.pem', $private_key_pem);
// file_put_contents('public_key.pem', $public_key_pem);
// file_put_contents('signature.dat', $signature);

// //verify signature
// $r = openssl_verify($data, $signature, $public_key_pem, "sha256WithRSAEncryption");
// var_dump($r);


// return base64_encode($signature) ;
   
// $stringB = "appid=850259476582401&merch_code=100000108&merch_order_id=1445072118&method=payment.preorder&nonce_str=5K8264pLTKCH16CQ2502nI8zNMTM6790&notify_url=https://www.google.com/google.com&timeout_express=120m&timestamp=1672072118&title=Ipone&total_amount=10&trade_type=InApp&trans_currency=USD&version=1.0";
// //    print_r($stringB);

    // $stringSorted = 'appid=853694808089602&business_type=BuyGoods&merch_code=245431&merch_order_id=1672066282692&method=payment.preorder&nonce_str=29JJ8UH7AVYFCS56UW6SYKI9WKAQK8MC&notify_url=http://197.156.68.29:5050/v2/api/order-v2/mini/payment&payee_identifier=245431&payee_identifier_type=04&payee_type=5000&redirect_url=http://197.156.68.29:8000&timeout_express=120m&timestamp=1672066283&title=req.body.title&total_amount=10&trade_type=InApp&trans_currency=ETB&version=1.0';
  


    // $pkeyid = openssl_pkey_get_private("file://src/openssl-0.9.6/demos/sign/key.pem");

// compute signature
// openssl_sign($StringA, $signature, $private_key);

// free the key from memory
// openssl_free_key($private_key);

// echo "ABENEII";
// print_r();
    return getRSAKeys(hash("sha256", $StringA));
    // return getRSAKeys($StringA);
    // $new_result = hash("sha256", $stringSorted);

    // var_dump($new_result);

    // print_r(hash("sha256", $StringA));exit;
    // print_r(ksort($stringA));
    // print_r($StringA);
    // return $new_result;
    // return encrypt_RSA($string);
    // return getRSAKeys($StringA);
    
}

function getRSAKeys($data){
    
    // $keyfile="file://".__DIR__.DIRECTORY_SEPARATOR."private_key.pem"; //absolute path
    // $key = openssl_pkey_get_private($keyfile);
    // $private_key = file_get_contents('private_key.pem'); 
    $private_key = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----
EOD;

//     $private_key = openssl_pkey_get_private('-----BEGIN PRIVATE KEY-----
// MIIG/QIBADANBgkqhkiG9w0BAQEFAASCBucwggbjAgEAAoIBgQCqoSNbCeNDkvcwFTo1s49p6qyQybviwhJ6okAJ/ENmGH9BW4sAjF+1pjqy4BUD31pKvid04zIkdoTq0+062HAnykrXuhJO4w/YoTBiXZrc3EJO0vkSQoSufiAru7elssJ+GXX+XxtCAKmgR3g1UkICeZtgeftXOXCC3uD/1/QnTgZQGoQzkJ+1noXGDHQlJBdJcn7kPakp1MY4sdCoFkjEyRDAZhtT2gdca7AvQl6blHj0/favmYOQdMT91+4m2MMsI1h0KTFZAcwuzAEIAq/VdcKK/WTe1x6BVatHkS+Hc1js4XPtlFDLb10UrDtU0ufzqQbb31/Qix5vCVTpoJegLrakjTxPUo/7N216gNdEDfoPCb33tu+5sQrVRj0Fk90xtQb/Vx/78ft0/cwmMJiTwa1mxQUpB98LzE2d2Am1iPfya+wj+KUu+TTfs+xjwh/IiU2ke0c2xir6WVgiO7ej860l8VM4vTtunjg3abGs4sDft3w55PtMWDV8FNEizrECAwEAAQKCAYBshi6pkaFlck0b3PR4AWu+zw7QzC5fLFZ6f0XB1Bu+DOirViETyTR6oW6GJLXZD68rCMSpuHNE88jYXtBs9ApplGWDzgok+JA0lVjjx2te/AyEe/UE4x/mp7uodS16Czde4qzEjBMXKLq6gZp4N4hacKQdeZgdwx/HbSCoON9GPH8RZbwd2+doqZml/HfGw6y3/0Wrv3gfbgBhQN9YeUvxNX0dEhRhgbPa2Xdmp4zq4UUJdZn31+jw8QP1++ex930nGlPZKMTGlSbev8CXAC+JlzjVJdZjSgGHF5lJBogy1KEzJkLXc1YL2ucNqX3Nf5u9TueHH47KYl4tw1YgwlG4Rl5iYYxW3/SEpExRCUFgLKyz6DY1Enu6au7giyXzy2Q5Mfnfje6Fft51oF3m/XbYxbI9gMPwrtQZJF7iWbqX+IvhzyzBqluiGshXlqbe8Jy8T81GAwqcEOmxRVmHT/W2Gx6sTdeZfKrTm2vFgyfYn2D/4L8exuNw7daUB5SKrgECgcEA7qVfqCIyIV3BvUGLgHkXi2TfoepfjsgehSqsnO/Qc+B8JagiW0jTw+VgkOo6uA4f02hGlF0GwdBOX8WOc/twHUgBK3G+w0gLZ5Q/BPNEe9FtrEFVd/ZDoWBS5NpNMX+NoWJnYOfizPIr2Rzo/+630iUypByUCAERIXJjdM+6T/qwc9MCpoWHuKgWqKiFJPlF5cX/3jYU9smh0AAv6KbY+wtbfwPgJXNlMIwY0zh8IX/yjfHm1/UmMf/3NcpcIqERAoHBALcJkhBGallggt5URqCrldWEuGiJ98N7NCH3+vvfWdkFUrXe/on1qztB9uj67p4ZUCs+D+SDJyhO+aZR+BhmlkV0O0/sGoYG0wm8OJQXdj1TXw0br/9p5h8RJrZNt5cY7EspOo/WUBjZrAV/GpAWRg3kg6I+HBuydQKKQtpMtAjg13OGD19TD26TbqSd4jPTM6IjRMvv4sCkux6403E7z3V9uhGdueE24csJiMs2NMpZIp+cplrOcHMQfnrGovNToQKBwQCFOGpa6KQFflpN9U4T7QVYunog4D5x7YMkIbt0bGd4mIOVXfO388LLo7uxiiA3aSMZGCf2YKwJ++gUjKtGUcG3ht+oSfoM96XuL5Kyh77eQ/4uX9Z/fkkoyCXePYNEM4lz4wQE084HTNVvgTUM0k1pkXxgotd8VGQkwL+GkQPX7AEe11eub/JhAeyMQG77QfBkIZEBkj1Huy2KeOBFxwZvtlpgYGB7Z5zAaiTdnLWm2c8ksDqGqgKlfNea/plKd5ECgcAFPrr2yG3HveJCKLwVYpValwEJzdpRubgWuRpyGUZj16k1GPzGS0nq2ssOhhJMaYFIm/Cspa17lDfHMlYfrODlgJ0qfyOLb6qgfspIRBvZSghRQdfbQ9eaUE2Br9xw8f/jb30EHioRbDtntOq38ktznna/MXRwvr5nojqkMsp97qN95fuOybyJeKQVB4kx3v19yfDwvyEKUC4khTtZ5VLelQm9830eHQp/XPiUiisdGUzKshx6QawrP++/6O1Gd8ECgcApD9c3PhMRyNAAjt0f6N4FsPCcxDq/jKXNNvqkmIQL/nz1ZG4glM7jORvu+JWzjiQAU01ihoKgvKp6xqrgz4Q62IJdINoTVg2KALTtZR+QORT3+BwDzyyGQgIb/I5F6JGc1/2QXVIH5PtIxOdUmCZnbwBx107NC4qRPsO2aaiS+5aL51VYzGzFGK8H6WYPd01DEUtgufZx2yo3N4Bu85Kc3f7FYIjxj18sldn8cRF62/MOebKIOChFJb9FLvFoTmM=
// -----END PRIVATE KEY-----');

    // echo "PRIVATE_KEY: ";
    // print_r($private_key);
    // $return = openssl_pkey_get_private($private_key); 

    // $key = PublicKeyLoader::load(file_get_contents('private_key.pem'), $password = false);

    // print_r($key);

    // echo "PRIVATE_KEY AFTER GET KEY: ";
    // print_r($return); exit;
    // echo "PRIVATE KEY_";

    // var_dump($private_key); exit;

    // $pubPem = chunk_split($private_key, 64, "\n");        
    // $pubPem = "-----BEGIN PRIVATE KEY-----" . "\n" . $pubPem . "-----END PRIVATE KEY-----\n";        
    // $private_key = openssl_pkey_get_private($pubPem);  
    // $private_key = $pubPem;

    // echo "PRIVATE KEY";
    // print_r($private_key_); exit;

    // $keyPairResource = openssl_pkey_new(array("private_key_bits" => 2048, "private_key_type" => OPENSSL_KEYTYPE_RSA)); 
    // openssl_pkey_export($keyPairResource, $privateKey);
    // return [$privateKey, openssl_pkey_get_details($keyPairResource)["key"]];
    
// openssl_private_encrypt(
//     $data,
//     $encrypted_data,
//     $private_key,
//     OPENSSL_PKCS1_PADDING
// );

    $crypto = ''; 
    foreach (str_split($data, 117) as $chunk) {            
        $return = openssl_private_encrypt($chunk, $cryptoItem, $private_key);            
        if (!$private_key) {                
            return ('fail');           
         }            
        $crypto .= $cryptoItem;        
    }        
    $ussd = base64_encode($crypto);        
    return $ussd;   

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

    //Block size for encryption block cipher
    $ENCRYPT_BLOCK_SIZE = 200;// this for 2048 bit key for example, leaving some room

    // //Block size for decryption block cipher
    $DECRYPT_BLOCK_SIZE = 256;// this again for 2048 bit key

    $encrypted = '';
        
    // $plainData = str_split($plainData, $ENCRYPT_BLOCK_SIZE);

    

    // $private_key = file_get_contents('./config/private_key.pem'); 

    // foreach($plainData as $chunk)
    // {
    //     $partialEncrypted = '';

    //     //using for example OPENSSL_PKCS1_PADDING as padding
    //     $encryptionOk = openssl_private_encrypt($chunk, $partialEncrypted, $private_key, OPENSSL_PKCS1_PADDING);

    //     if($encryptionOk === false){return false;}//also you can return and error. If too big this will be false
    //     $encrypted .= $partialEncrypted;
    // }
    //  $crypted = '';
    // $new_encrypted = openssl_private_encrypt ($plainData, $crypted , $private_key,OPENSSL_PKCS1_PADDING);
    //  $encrypted .= $crypted;
    // print_r(base64_encode($crypted));
    // return base64_encode($encrypted);//encoding the whole binary String as MIME base 64

        //     $binary_signature = "";

        // $algo = "sha256WithRSAEncryption";

        // $private_key = "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"; 

        // openssl_sign($plainData, $binary_signature, $private_key, $algo);
        // $signature = base64_encode($binary_signature);
        // // echo $timestamp = time();
        // // echo "<br>";
        // // print_r($signature);

        // return base64_encode($signature);//encoding the whole binary String as MIME base 64



            // $pubPem = chunk_split($public, 64, "\n");        
            // $pubPem = "-----BEGIN PUBLIC KEY-----\n" . $pubPem . "-----END PUBLIC KEY-----\n";        
            // $private_key = file_get_contents('../private_key.pem');  
                
            // if (!$private_key) {            
            //     die('invalid public key');        
            // }   

            // $crypto = '';


            // foreach (str_split($data, 117) as $chunk) { 
                        
            //     $return = openssl_private_encrypt($chunk, $cryptoItem, $private_key);            
            //     if (!$return) {                
            //         return ('fail');           
            //      }            
            //     $crypto .= $cryptoItem;        
            // }        
            // $ussd = base64_encode($crypto);     
            // return $ussd;   



            // $private_key = <<<EOD
            // -----BEGIN RSA PRIVATE KEY-----
            // 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
            // -----END RSA PRIVATE KEY-----
            // EOD;

            // $binary_signature = "";

            // $algo = "sha256WithRSAEncryption";

            // openssl_sign($data, $binary_signature, $private_key, $algo);
            // $signature = base64_encode($binary_signature);
            // // echo $timestamp = time();
            // // echo "<br>";
            // // print_r($signature);
            // return $signature;
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


