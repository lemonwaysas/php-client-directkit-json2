<?php
require_once "./LemonWay.php";

echo "<p>---------- Wallet sc: ----------</p>\n";
try {
	$response = callService("GetWalletDetails", array(
	            "wallet" => "sc"
	        ));
	echo "\n<pre>\n".json_encode($response, JSON_PRETTY_PRINT)."\n</pre>\n";
}
catch (Exception $e) 
{
	echo ($e);
}

echo "<p>---------- Wallet notexist: ----------</p>\n";
try {
	$response = callService("GetWalletDetails", array(
	            "wallet" => "notexist"
	        ));
	echo "\n<pre>\n".json_encode($response, JSON_PRETTY_PRINT)."\n</pre>\n";	
}
catch (Exception $e) 
{
	echo ($e);
}
