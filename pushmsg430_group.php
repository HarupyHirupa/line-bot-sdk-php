<?php

   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order_430.php?task=get_new_order');
   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   $retData = curl_exec($curlSession);
   curl_close($curlSession);	
   $pos = stripos($retData, '#', 0);
   $replyData = substr($retData, 0, $pos);
   $groupID = substr($retData, $pos+1, strlen($retData)-$pos+1);	 

   //echo 'raw=>'.$replyData;		
   if(stripos($replyData,"Open Order",0) < 0) {$replyData = "No new order.!!";}		
   //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   $accessToken = "W9XPAiTihrq4YYec21gDIEpts/88RGZc18uiz81uCykGu4kwSazkEgBvs8e0RuA/nUi0K2mcINn5ubtzOCnLFBc2NlE9DRLn+JE+az+MHtr8rW11X2vbn7PbEntBCv3GFuaAk3/Ordvix/E9pwJT2wdB04t89/1O/w1cDnyilFU=";
   $groupID = "C41a4796d0c1af51d998d88d32eae52ba";
   echo $replyData.'|Group ID =>'.$groupID;
	
   //$content = file_get_contents('php://input');
   //$arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   $arrayPostData['to'] = $groupID;
   $arrayPostData['messages'][0]['type'] = "text";
   $arrayPostData['messages'][0]['text'] = $replyData ;
   $arrayPostData['messages'][1]['type'] = "sticker";
   $arrayPostData['messages'][1]['packageId'] = "2";
   $arrayPostData['messages'][1]['stickerId'] = "34";
   pushMsg($arrayHeader,$arrayPostData);



   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
	
		
   exit;
?>

