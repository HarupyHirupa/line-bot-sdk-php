<?php

   $task = $_REQUEST['task'];
   //echo "Task = $task \r\n";
	
   $symbol = $_REQUEST['symbol'];
   //echo "symbol = $symbol \r\n";

   $op_price = $_REQUEST['op_price'];
   //echo "op_price = $op_price \r\n";	

   $tp_price = $_REQUEST['tp_price'];
   //echo "tp_price = $tp_price \r\n";

   $sl_price = $_REQUEST['sl_price'];
   //echo "sl_price = $sl_price \r\n";

   $op_type = $_REQUEST['op_type'];
   //echo "op_type = $op_type \r\n";	
/*
   $seq_id = $_REQUEST['seq_id'];
   //echo "seq_id = $seq_id \r\n";
*/
   $g_id = $_REQUEST['g_id'];
   //echo "g_id = $g_id \r\n";


   $replyData = "";
   if($task == "direct_push")
   {
	if($op_type == 1)
	{
		$replyData = "Open Order\n BUY : $symbol => $op_price\nTP => $tp_price\nSL => $sl_price\r\n";
	}
	else if($op_type == 2)
	{
		$replyData = "Open Order\n SELL : $symbol => $op_price\nTP => $tp_price\nSL => $sl_price\r\n";
	}
   				
   	//echo 'raw=>'.$replyData;
		
   	//if(strpos($replyData, "Open Order") == false) {$replyData = "No new order.!!";}		
   	//$replyData = "Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
   	$accessToken = "W9XPAiTihrq4YYec21gDIEpts/88RGZc18uiz81uCykGu4kwSazkEgBvs8e0RuA/nUi0K2mcINn5ubtzOCnLFBc2NlE9DRLn+JE+az+MHtr8rW11X2vbn7PbEntBCv3GFuaAk3/Ordvix/E9pwJT2wdB04t89/1O/w1cDnyilFU=";
   	//$groupID = "C41a4796d0c1af51d998d88d32eae52ba";
 	$groupID = $g_id;
   	echo $replyData;
 	
	//$bot_name = "430 Signal";
   	//for($i=1;$i<=3;$i++)
	{
		/*
		$curlSession = curl_init();
   		curl_setopt($curlSession, CURLOPT_URL, 'http://tangmee.com/feedmepro/get_group_id.php?task=get_g_id&bot_name='.$bot_name.'&rec_id='.$seq_id);
   		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
   		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

   		$groupID = curl_exec($curlSession);
   		curl_close($curlSession);
		//echo 'Group=>'.$groupID;
		*/

   		//$content = file_get_contents('php://input');
   		//$arrayJson = json_decode($content, true);
   		$arrayHeader = array();
   		$arrayHeader[] = "Content-Type: application/json";
   		$arrayHeader[] = "Authorization: Bearer {$accessToken}";
   		$arrayPostData['to'] = $groupID;
   		$arrayPostData['messages'][0]['type'] = "text";
   		$arrayPostData['messages'][0]['text'] = $replyData;
		//$arrayPostData['messages'][0]['text'] = $groupID;
   		$arrayPostData['messages'][1]['type'] = "sticker";
   		$arrayPostData['messages'][1]['packageId'] = "2";
   		$arrayPostData['messages'][1]['stickerId'] = "34";
   		pushMsg($arrayHeader,$arrayPostData);
   	}
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

/*	
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
     $accessToken = "oPkXa0tKzfxfMCjx6gm5iirMYaHeXia/Fsy1R9Lt8lRybMocm/seOqBvbIaHYkqtprR4DgHJcmsI6XNoatxGLYidiWJQEO0acDULgyJSHB2EOHNRAFXHxOuC0tP7KwiibUSgyuz6kB+MKKZf17qjYgdB04t89/1O/w1cDnyilFU=";//copy ��ͤ��� Channel access token �͹����駤��
     echo $replyData;
   }
*/
		
   exit;
?>

