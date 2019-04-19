

<?php


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
	//echo "Database Connected.";  
}  
else  
{  
	//echo "Database Connect Failed.";  
}  

$task = $_REQUEST['task'];
//echo "Task = $task \r\n";

$rec_id = 0;

if ($task === "get_new_order")
{
	
	$params = array("");
	$tsql = "SELECT TOP 1 [REC_ID], [SYMBOL], [OP_PRICE], [TP_PRICE], [SL_PRICE], [OP_TYPE], [TIME_STAMPT] FROM [FLIGHT_INFO].[dbo].[TB_OP_ORDER] WHERE ([NOTIFY] IS NULL)";

	/*Execute the query with a scrollable cursor so
  	we can determine the number of rows returned.*/


	$cursorType = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

	$recordSet = sqlsrv_query($objConnect, $tsql, $params, $cursorType);
	if ( $recordSet  === false)
		die( FormatErrors( sqlsrv_errors() ) );

	if(sqlsrv_has_rows($recordSet))
	{
		$rowSec = 0;
		$rowCount = sqlsrv_num_rows($recordSet);
		//echo "[";
		while ( $row = sqlsrv_fetch_array( $recordSet, SQLSRV_FETCH_ASSOC)) 
		{
			$rowSec++;
			$rec_id = $row['REC_ID'];
			PopulateTable( $row, $rowCount, $rowSec);

		}
		//echo "]";

	}
	else
	{
		//DisplayNoDataMsg();
	}
	
	/*
	$tsql_i = "UPDATE [FLIGHT_INFO].[dbo].[TB_OP_ORDER] SET [NOTIFY] = GETDATE() WHERE ([REC_ID] = $rec_id)";	
	$params_i = array("");
	//echo $tsql_i;

	
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
		//echo "Pass execute to update OK\n\r";
   	}
   	else
  	{
		//echo "Fail execute to update\n\r";
		die( print_r( sqlsrv_errors(), true));
  	} 
	*/
}


function PopulateTable( $values, $rowCount, $rowSec )
{
	$rec_id = $values['REC_ID'];
	$ssymbol = $values['SYMBOL'];
	$op_p = $values['OP_PRICE'];
	$tp_p = $values['TP_PRICE'];	
	$sl_p = $values['SL_PRICE'];
	$op_t = $values['OP_TYPE'];
	//echo "opData=$ssymbol;$op_p;$tp_p;$sl_p;\r\n";
	
	
	if($op_t == 1)
	{
		//echo 'Open Order\n BUY : '.$ssymbol.' => '.$op_p.'\nTP => '.$tp_p.'\nSL => '.$sl_p;
		echo "Open Order\n BUY : $ssymbol => $op_p\nTP => $tp_p\nSL => $sl_p\r\n";
		//echo "Open Order\n BUY :$ssymbol;$op_p;$tp_p;$sl_p;\r\n";
	}
	else if($op_t == 2)
	{
		//echo 'Open Order\n SELL : '.$ssymbol.' => '.$op_p.'\nTP => '.$tp_p.'\nSL => '.$sl_p;
		echo "Open Order\n SELL : $ssymbol => $op_p\nTP => $tp_p\nSL => $sl_p\r\n";
		//echo "Open Order\n SELL :$ssymbol;$op_p;$tp_p;$sl_p;\r\n";
	}
	
	//"Reply Test\nSELL:GBPUSD => 1.29852\nTP => 128652\nSL => 1.29452";
	//updateRecord($rec_id);
	

}


function updateRecord($rid)
{ 	
	$tsql_i = "UPDATE [FLIGHT_INFO].[dbo].[TB_OP_ORDER] SET [NOTIFY] = GETDATE() WHERE ([REC_ID] = $rid)";	
	$params_i = array("");
	//echo $tsql_i;

	
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
		//echo "Pass execute to update OK\n\r";
   	}
   	else
  	{
		//echo "Fail execute to update\n\r";
		die( print_r( sqlsrv_errors(), true));
  	} 

}


function EndEchoTable()
{ 
    echo "</table><br/>"; 
}


sqlsrv_close($objConnect);


?>


