<?php
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
#	curl_setopt($curl, CURLOPT_PROXY, "proxy.hinet.net:80");		// Proxy
#	curl_setopt($curl, CURLOPT_PROXYUSERPWD, ":");					// If Need Username:Password
	curl_setopt($curl, CURLOPT_URL, $URL);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response_data = urldecode(urldecode(curl_exec($curl)));
#	echo 'Curl error: ' . curl_error($curl);						// Curl Error Information
	curl_close($curl);												// Close Curl