<?php

   set_time_limit(0);

   $interval=1; //minutes
   echo str_repeat(" ", 1024);
   while(true) {
       $now=time();
       echo $now."<BR>";
       sleep($interval * 60);
       flush();
   }
/*   
   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order_test.php?task=get_new_order');
   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   $replyData = curl_exec($curlSession);
   curl_close($curlSession);	
   
   //echo 'raw=>'.$replyData;		
   if(strpos($replyData, "Open Order") == false) {$replyData = "No new order.!!";}		
   //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   $accessToken = "oPkXa0tKzfxfMCjx6gm5iirMYaHeXia/Fsy1R9Lt8lRybMocm/seOqBvbIaHYkqtprR4DgHJcmsI6XNoatxGLYidiWJQEO0acDULgyJSHB2EOHNRAFXHxOuC0tP7KwiibUSgyuz6kB+MKKZf17qjYgdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   echo $replyData;
*/	
   
/*   
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
     curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_new_order_test.php?task=get_new_order');
     curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
     curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

     $replyData = curl_exec($curlSession);
     curl_close($curlSession);	
   
     //echo 'raw=>'.$replyData;		
     if(strpos($replyData, "Open Order") == false) {$replyData = "No new order.!!";}		
     //$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
     $accessToken = "oPkXa0tKzfxfMCjx6gm5iirMYaHeXia/Fsy1R9Lt8lRybMocm/seOqBvbIaHYkqtprR4DgHJcmsI6XNoatxGLYidiWJQEO0acDULgyJSHB2EOHNRAFXHxOuC0tP7KwiibUSgyuz6kB+MKKZf17qjYgdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
     echo $replyData;
   }
*/
		
   exit;
?>

