<?php

   $bot_name = "430_signal";	
   
	
   		
   //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   $accessToken = "oPkXa0tKzfxfMCjx6gm5iirMYaHeXia/Fsy1R9Lt8lRybMocm/seOqBvbIaHYkqtprR4DgHJcmsI6XNoatxGLYidiWJQEO0acDULgyJSHB2EOHNRAFXHxOuC0tP7KwiibUSgyuz6kB+MKKZf17qjYgdB04t89/1O/w1cDnyilFU=";
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   
   $message = $arrayJson['events'][0]['message']['text'];
   
   $id = $arrayJson['events'][0]['source']['groupId'];

   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order.php?task=get_new_order&g_id='.$id);
   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   $replyData = curl_exec($curlSession);
   curl_close($curlSession);	
   //echo $replyData;
   if(strpos($replyData, "Open Order") == false) {$replyData = "No new order.!!";}
	
   if($message == "request"){
	$arrayPostData['to'] = $id;
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $replyData ;
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "2";
        $arrayPostData['messages'][1]['stickerId'] = "34";
        pushMsg($arrayHeader,$arrayPostData);
      for ($i=0; $i <= 30; $i++) {
         $replyData = callUrlData($id);
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
	else if(strpos($retData, "already existing.") {$replyData = "#update OK#";}
	else {$replyData = "#update Fail#";}
	

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
	
   function callUrlData($gID){
     $curlSession = curl_init();
     curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order.php?task=get_new_order&g_id='.$gID);
     curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
     curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

     $retData = curl_exec($curlSession);
     curl_close($curlSession);
     return $retData;
   }
	
   exit;
?>

