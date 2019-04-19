<?php

   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order.php?task=get_new_order');
   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   $replyData = curl_exec($curlSession);
   curl_close($curlSession);	
   //echo $replyData;
	
   if(strpos($replyData, "Open Order") < 0) {$replyData = "No open order.!!";}		
   //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   $accessToken = "oPkXa0tKzfxfMCjx6gm5iirMYaHeXia/Fsy1R9Lt8lRybMocm/seOqBvbIaHYkqtprR4DgHJcmsI6XNoatxGLYidiWJQEO0acDULgyJSHB2EOHNRAFXHxOuC0tP7KwiibUSgyuz6kB+MKKZf17qjYgdB04t89/1O/w1cDnyilFU=";//copy ��ͤ��� Channel access token �͹����駤��
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //�Ѻ��ͤ����ҡ�����
   $message = $arrayJson['events'][0]['message']['text'];
   //�Ѻ id �ͧ�����
   $id = $arrayJson['events'][0]['source']['groupId'];
   #������ҧ Message Type "Text + Sticker"
   if($message == "request"){
      $arrayPostData['to'] = $id;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = $replyData ;
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "2";
      $arrayPostData['messages'][1]['stickerId'] = "34";
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


   exit;
?>

