<?php

   $bot_name = "430 Signal"; 	
   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order_430.php?task=get_new_order');
   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   $retData = curl_exec($curlSession);
   curl_close($curlSession);	
   $pos = stripos($retData, '#', 0);
   $replyData = substr($retData, 0, $pos);
   $groupID = substr($retData, $pos+1, strlen($retData)-$pos+1);

	
   if(stripos($replyData,"Open Order",0) < 0) {$replyData = "No new order.!!";}		
   //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   $accessToken = "W9XPAiTihrq4YYec21gDIEpts/88RGZc18uiz81uCykGu4kwSazkEgBvs8e0RuA/nUi0K2mcINn5ubtzOCnLFBc2NlE9DRLn+JE+az+MHtr8rW11X2vbn7PbEntBCv3GFuaAk3/Ordvix/E9pwJT2wdB04t89/1O/w1cDnyilFU="; 
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";

   $message = $arrayJson['events'][0]['message']['text'];

   $id = $arrayJson['events'][0]['source']['groupId'];
  //echo $id; 
  
   if($message == "request"){
	$arrayPostData['to'] = $id;
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $replyData ;
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "2";
        $arrayPostData['messages'][1]['stickerId'] = "34";
        pushMsg($arrayHeader,$arrayPostData);
      for ($i=0; $i <= 30; $i++) {
         $replyData = callUrlData();
         if(strpos($replyData, "Open Order") == false) {
             break;
         }
    	 sleep(5); // this should halt for 3 seconds for every loop

         $arrayPostData['to'] = $id;
         $arrayPostData['messages'][0]['type'] = "text";
         $arrayPostData['messages'][0]['text'] = $replyData ;
         $arrayPostData['messages'][1]['type'] = "sticker";
         $arrayPostData['messages'][1]['packageId'] = "2";
         $arrayPostData['messages'][1]['stickerId'] = "34";
         pushMsg($arrayHeader,$arrayPostData);
      }
   }
   else if($message == "saveid"){
	//saveGroupID($id);
	$replyData = "Save ID in Process";
	
	$arrayPostData['to'] = $id;
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $replyData;
	pushMsg($arrayHeader,$arrayPostData);

	$gr_url = 'http://tangmee.com/feedmepro/save_new_group.php?task=save_new_group&g_id='.$id.'&bot_name='.$bot_name;
	$use_url = preg_replace('/ /', '%20', $gr_url);
	
	$curlSession = curl_init();
     	curl_setopt($curlSession, CURLOPT_URL, $use_url);
     	curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
     	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

     	$retData = curl_exec($curlSession);
     	curl_close($curlSession);
	if(strpos($retData, "#update OK#") == true) {$replyData = "#update OK#.!!";}
	else {$replyData = "#update Failure#.!!";}
	

	$arrayPostData['to'] = $id;
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $replyData;
	//$arrayPostData['messages'][0]['text'] = $use_url;
	pushMsg($arrayHeader,$arrayPostData);

   }


	
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
	
   function callUrlData(){
     curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order_430.php?task=get_new_order');
     curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
     curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

     $retData = curl_exec($curlSession);
     curl_close($curlSession);	
     $pos = stripos($retData, '#', 0);
     $rData = substr($retData, 0, $pos);
     $groupID = substr($retData, $pos+1, strlen($retData)-$pos+1);
     return $rData;
   }
		
   exit;
?>

