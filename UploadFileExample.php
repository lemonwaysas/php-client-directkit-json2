<?php
require_once "./LemonWay.php";

try {
    $buffer = base64_encode(file_get_contents('images/test.jpeg', true));
	$response = callService("UploadFile", array(
	            "wallet" => "8888",
                "fileName" => "test.jpg",
                "type" => "3",
                "buffer" => $buffer
	        ));
	echo "\n<pre>\n".json_encode($response, JSON_PRETTY_PRINT)."\n</pre>\n";
}
catch (Exception $e) {
	echo ($e);
}

?>
