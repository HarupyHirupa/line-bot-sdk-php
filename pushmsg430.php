<?php

   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order.php?task=get_new_order');
   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   $replyData = curl_exec($curlSession);
   curl_close($curlSession);	
   //echo $replyData;
	
   if(strpos($replyData, "Open Order") == false) {$replyData = "No new order.!!";}		
   //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   $accessToken = "W9XPAiTihrq4YYec21gDIEpts/88RGZc18uiz81uCykGu4kwSazkEgBvs8e0RuA/nUi0K2mcINn5ubtzOCnLFBc2NlE9DRLn+JE+az+MHtr8rW11X2vbn7PbEntBCv3GFuaAk3/Ordvix/E9pwJT2wdB04t89/1O/w1cDnyilFU="; //copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับข้อความจากผู้ใช้
   $message = $arrayJson['events'][0]['message']['text'];
   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['groupId'];
  //echo $id; 
  //saveGroupID($id);
   #ตัวอย่าง Message Type "Text + Sticker"
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
	saveGroupID($id);
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
     $curlSession = curl_init();
     curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order.php?task=get_new_order');
     curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
     curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

     $retData = curl_exec($curlSession);
     curl_close($curlSession);
     return $retData;
   }

/*
   function saveGroupID($gid){
     if($gid !== "")
	{
     		$curlSession = curl_init();
     		curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/save_new_group.php?task=save_new_group&g_id='.$gid.');
     		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
     		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

     		$retData = curl_exec($curlSession);
     		curl_close($curlSession);
 	}
   }
*/		
   exit;
?>

