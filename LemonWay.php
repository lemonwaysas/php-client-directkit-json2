<?php
/* 
* Put the Directkit JSON2 here (your should see "json2" in your URL)
* Make sure your server is whitelisted, otherwise you will receive 403-forbidden
*/
define('DIRECTKIT_JSON2', 'https://sandbox-api.lemonway.fr/mb/demo/dev/directkitjson2/Service.asmx');
define('LOGIN', 'society');
define('PASSWORD', '123456');
define('VERSION', '1.8');
define('LANGUAGE', 'en');
define('SSL_VERIFICATION', false);
define('UA', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'ua');

/*
IP of end-user
*/
function getUserIP() {
	$ip = '';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	elseif (!empty($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else {
		$ip = "127.0.0.1";
	}
	return $ip;
}

function callService($serviceName, $parameters) {
    // add missing required parameters
	$parameters['wlLogin'] = LOGIN;
	$parameters['wlPass'] = PASSWORD;
	$parameters['version'] = VERSION;
	$parameters['walletIp'] = getUserIP();
	$parameters['walletUa'] = UA;

	// wrap to 'p'
	$request = json_encode(array('p' => $parameters));
    $serviceUrl = DIRECTKIT_JSON2.'/'.$serviceName;

	$headers = array("Content-type: application/json;charset=utf-8",
					            "Accept: application/json",
					            "Cache-Control: no-cache",
					            "Pragma: no-cache"
                                //"Content-Length:".strlen($request)
					        );

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $serviceUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_VERIFICATION);
	
    $response = curl_exec($ch);

    $network_err = curl_errno($ch);
	if ($network_err) {
		error_log('curl_err: ' . $network_err);
		throw new Exception($network_err);
	}
	else {
        $httpStatus = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		if ($httpStatus == 200)  {
            $unwrapResponse = json_decode($response)->d;
            $businessErr = $unwrapResponse->E;
            if ($businessErr) {
                error_log($businessErr->Code." - ".$businessErr->Msg." - Technical info: ".$businessErr->Error);
                throw new Exception($businessErr->Code." - ".$businessErr->Msg);
            }
            return $unwrapResponse;
        }
        else {
            throw new Exception("Service return HttpStatus $httpStatus");
        }
	}
}
