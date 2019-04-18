<?php

function writeFile($data){
  $logPath = __DIR__. "pairTrade.txt";
  $mode = (!file_exists($logPath)) ? 'w':'a';
  $logfile = fopen($logPath, $mode);
  fwrite($logfile, "\r\n". $data);
  fclose($logfile);
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
	
   if ($task === "upd_new_order")
   {
	$saveData = '#Symbol='.$symbol.'#op_price='.$op_price.'#tp_price='.$op_price.'#sl_price='.$sl_price.'#notify=no';
	writeFile($saveData);
   }


	
