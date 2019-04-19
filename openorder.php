<?php
/*
function writeFile($data){
  $logPath = __DIR__. "pairTrade.txt";
  $mode = (!file_exists($logPath)) ? 'w':'a';
  $logfile = fopen($logPath, $mode);
  fwrite($logfile, "\r\n". $data);
  fclose($logfile);
}
*/

$server = "WIN08R2X64\sqlexpress";
$user = "sa"; 
$pass = "pr@159753"; 
$db_name="FLIGHT_INFO";  
$connectionInfo = array( "UID"=>$user,
                         "PWD"=>$pass,
                         "Database"=>$db_name);

$objConnect = sqlsrv_connect($server, $connectionInfo) or die("Error Connect to Database");

if($objConnect)  
{  
	echo "Database Connected.";  
}  
else  
{  
	echo "Database Connect Failed.";  
} 


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

   $ticket_id = $_REQUEST['ticket_id'];
   //echo "ticket_id = $ticket_id \r\n";

   $preSQL = "INSERT INTO [FLIGHT_INFO].[dbo].[TB_OP_ORDER]";	
	//echo $preSQL;	
	
   if ($task === "upd_new_order")
   {
	$st_time = GETDATE();
	$tsql_i = $preSQL." ([SYMBOL], [OP_PRICE], [TP_PRICE], [SL_PRICE], [OP_TYPE], [TICKET], [TIME_STAMP]) VALUES (?,?,?,?,?,?,?);";
	$params_i = array(&$symbol,&$op_price,&$tp_price,&$sl_price,&$op_type,&$ticket_id,&$st_time);
	// Prepare and execute the statement. 
	if ($updateReview  = sqlsrv_prepare($objConnect , $tsql_i, $params_i))
   	{
		//echo "Pass prepare to update\n\r";
   	}
   	else
   	{
		//echo "Fail prepare to update\n\r";
		die( print_r( sqlsrv_errors(), true));
   	}

	// By default, all stream data is sent at the time of
	//query execution. 

	if( sqlsrv_execute($updateReview ))
 	{
		echo "#update OK#";
   	}
   	else
  	{
		echo "#update FAIL#";
		die( print_r( sqlsrv_errors(), true));
  	} 

   }


sqlsrv_close($objConnect);

?>

	
