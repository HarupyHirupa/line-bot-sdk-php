<?php
      //$tempFolder = '/tmp';
      //$webRootFolder = '/var/www';
      $scriptName = 'pushmsg.sh';
      //$moveCommand = "mv $webRootFolder/$scriptName $tempFolder/$scriptName";
      //$output = shell_exec($moveCommand);
	$output = shell_exec($scriptName);
	echo $output;
?>
