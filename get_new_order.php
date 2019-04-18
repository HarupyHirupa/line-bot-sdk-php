

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


if ($task === "get_new_order")
{
	
	$params = array("");
	$tsql = "SELECT [SYMBOL], [OP_PRICE], [TP_PRICE], [SL_PRICE], [OP_TYPE], [TIME_STAMPT] FROM [FLIGHT_INFO].[dbo].[TB_OP_ORDER] WHERE ([NOTIFY] IS NULL)";

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
			PopulateTable( $row, $rowCount, $rowSec);

		}
		//echo "]";

	}
	else
	{
		//DisplayNoDataMsg();
	}

}

/*
function PopulateTable( $values, $rowCount, $rowSec )
{
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
}
*/

function PopulateTable( $values, $rowCount, $rowSec )
{
    /* Populate Products table with search results. */
    $arrData = array();
    $col = 0;
    //$recordID = $values['REC_ID'];
    $arrData = $values;
    echo "#{\"OPEN ORDER\":";
    echo json_encode($arrData);
	if ($rowCount == $rowSec)
		{
    			echo "}#";
		}
		else
		{
			echo "}#;";
		}
}


function EndEchoTable()
{ 
    echo "</table><br/>"; 
}


sqlsrv_close($objConnect);


?>


