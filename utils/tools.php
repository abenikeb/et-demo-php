<?php

$req = array('timestamp' => "TTT", 
             'nonce_str' => "NNN",
             'method' => "payment.preorder",
             'version' => '1.0',
             'biz_content' => []
             );

$biz = array('notify_url' => 'https://www.google.com' , 
             'trade_type' => "InApp",
             'appid' => "12322323",
             'merch_code' => '1.0',
             'merch_order_id' => 'https://www.google.com' , 
             'title' => "InApp[ofoero",
             'total_amount' => "12322323",
             'trans_currency' => '1.0',
             'timeout_express' => '1.0'
              );

$req['biz_content'] = $biz;
// print_r(json_encode($req));

$final_result = json_encode($req);

signRequestObject($req);

function signRequestObject($req) {
  $fields = [];
  $fieldMap = [];

  for ($i=0; $i<count($req); $i++) {
    array_push($fields, array_keys($req)[$i]);
    // print_r($req['biz_content']);

    if ($req['biz_content']) {

      print_r($req['biz_content']);
      $biz = $req['biz_content'];
      foreach ($biz as $b) {
        
        // fields.push(key);
        // fieldMap[key] = biz[key];
        array_push($fields, $b);
      }
  }

  print_r($fields);

   
    // if(gettype($req[array_keys($req)[$i]]) !== 'array'){
    //     array_push($fieldMap, $req[array_keys($req)[$i]]);
    // }  
  }

  // array_pop($req);

  // $signStrList = [];

  // for ($i = 0; $i < count($fields); $i++) {
  //   $key = $fields[$i];
  //   array_push($signStrList, $key + "=" + $fieldMap[$key]);
  //   // $signStrList.push($key + "=" + $fieldMap[$key]);
  // }

}

//   for (let key in requestObject) {
//     // if (excludeFields.indexOf(key) >= 0) {
//     //   continue;
//     // }
//     fields.push(key);
//     fieldMap[key] = requestObject[key];
//   }
  // the fields in "biz_content" must Participating signature
//   if (requestObject.biz_content) {
//     $biz = requestObject.biz_content;
//     for (let key in biz) {
//     //   if (excludeFields.indexOf(key) >= 0) {
//     //     continue;
//     //   }
//       fields.push(key);
//       fieldMap[key] = biz[key];
//     }
//   }
//   // sort by ascii
//   fields.sort();


//   let signOriginStr = signStrList.join("&");
//   console.log("signOriginStr", signOriginStr);
//   return signString(signOriginStr, config.privateKey);


