<html>

<head>

<title>feedmepro.com PHP </title>

</head>

<body>

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
	echo "Database Connected.\n";  
}  
else  
{  
	echo "Database Connect Failed.\n";  
}  

$task = $_REQUEST['task'];
//echo "Task = $task \r\n";

$g_id = $_REQUEST['g_id'];
//echo "g_id = $g_id \r\n";


if ($task = "save_new_group")
{
	$params = array(&$g_id);
	//echo "params = $params \r\n";

	$tsql = "SELECT * FROM [FLIGHT_INFO].[dbo].[TB_GROUP_ID] WHERE ([GROUP_ID] = ?)";

	$cursorType = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	//echo "tsql = $tsql \r\n";

	$recordSet = sqlsrv_query($objConnect, $tsql, $params, $cursorType);

	if ( $recordSet === false)
	{
		die( FormatErrors( sqlsrv_errors() ) );
		echo "error recordset not create \r\n";
	}
		
	if(sqlsrv_has_rows($recordSet))
	{
	
	}
	else
	{
		$vValid = 1;		
		$tsql_i = "INSERT INTO [FLIGHT_INFO].[dbo].[TB_GROUP_ID] ([GROUPID], [VALID]) VALUES (?,?);";
		$params_i = array(&$g_id,&$vValid);
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
	
		sqlsrv_free_stmt( $updateReview );
	}
}

sqlsrv_close( $objConnect );


?>

</body>

</html>
