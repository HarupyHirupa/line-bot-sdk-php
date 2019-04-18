
<?php


$fh = fopen('groupid.txt','r');
while ($line = fgets($fh)) {
  // <... Do your work with the line ...>
  // echo($line);
  	if (strpos($line, 'group_1=') >= 0 && strpos($line, 'group_1=') < strlen($line))
	{
		//$gruop_id = substr($line, strpos($line, 'group_1=')+1, strlen($line)-trpos($line, 'group_1='));
	}
    		
}
fclose($fh);
//echo "ID=>".$gruop_id;


$access_token = 'oPkXa0tKzfxfMCjx6gm5iirMYaHeXia/Fsy1R9Lt8lRybMocm/seOqBvbIaHYkqtprR4DgHJcmsI6XNoatxGLYidiWJQEO0acDULgyJSHB2EOHNRAFXHxOuC0tP7KwiibUSgyuz6kB+MKKZf17qjYgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
 // Loop through each event
 foreach ($events['events'] as $event) {
  // Reply only when message sent is in 'text' format
  if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
   // Get text sent
   
/*	
   if(isset($arrayJson['events'][0]['source']['userId']){
      $id = 'userId'.$arrayJson['events'][0]['source']['userId'];
   }
   else if(isset($arrayJson['events'][0]['source']['groupId'])){
      $id = 'groupId'.$arrayJson['events'][0]['source']['groupId'];
   }
   else if(isset($arrayJson['events'][0]['source']['room'])){
      $id = 'room'.$arrayJson['events'][0]['source']['room'];
   }
   */

// Get replyToken
   $replyToken = $event['replyToken'];

	
//$id1 = 'userId=>'.$event['source']['userId'];
//$id2 = 'groupId=>'.$event['source']['groupId'];
//$id3 = 'roomId=>'.$event['source']['room'];

   //$text = 'Reply Token=>'.$replyToken.'|'.$id1.'|'.$id2.'|'.$id3.'|'.'Yepppppppp=>'.$event['message']['text'];	
	
   $text = 'Yepppppppp';
   

   // Build message to reply back
   $messages = [
    'type' => 'text',
    'text' => $text
   ];

   // Make a POST Request to Messaging API to reply to sender
   $url = 'https://api.line.me/v2/bot/message/reply';
   $data = [
    'replyToken' => $replyToken,
    'messages' => [$messages],
   ];
   $post = json_encode($data);
   $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   $result = curl_exec($ch);
   curl_close($ch);

   echo $result . "\r\n";
  }
 }
}
echo "OK";
//echo "ID=>".$gruop_id;
//echo $gruop_id;


