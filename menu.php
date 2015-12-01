<?php
    $appid = "wxd6047c7550e0899a";
    $appsecret = "7215fba08d2f147c909beaff46bbb559 ";
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $jsoninfo = json_decode($output, true);
    $access_token = $jsoninfo["access_token"];
    echo $access_token.'<br/>';
$jsonmenu = '{
     "button":[
     {    
          "type":"click",
          "name":"快速查找",
          "key":"TIPS"
      },
      {
           "name":"热门地区",
           "sub_button":[
       {
         "type":"click",
         "name":"大温哥华区",
         "key":"wgh"
       },
       {
         "type":"click",
         "name":"大维多利亚区",
         "key":"wdly"
       },
       {
         "type":"click",
         "name":"纳奈莫区",
         "key":"nnm"
       }
       ]
      },
      {
          
       "type":"click",
       "name":"联系小天天",
       "key":"http://dailynet.ca/weixin/"
         
       }]
 }';
    
    $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
    $result = https_request($url, $jsonmenu);
    var_dump($result);
    
    function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
?>