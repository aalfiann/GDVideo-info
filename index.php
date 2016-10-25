<?php
	$URL = "https://drive.google.com/get_video_info?docid=".$_SERVER["QUERY_STRING"];
	if (strlen($_SERVER["QUERY_STRING"]) != "28") {
		echo "請輸入正確的影片ID。例：<a href='/?0B757HvrhbFeienJaWnFfWGtQYUU'> http://www.domain.com/?0B757HvrhbFeienJaWnFfWGtQYUU</a>";
	} else {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//		curl_setopt($curl, CURLOPT_PROXY, "proxy.hinet.net:80");		// 代理伺服器
//		curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxyauth);			// 代理如果需要帳號&密碼
		curl_setopt($curl, CURLOPT_URL, $URL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response_data = curl_exec($curl);
//		echo 'Curl error: ' . curl_error($curl); 						// Curl偵錯
		curl_close($curl);
		$query = urldecode(urldecode($response_data));
		preg_match_all("/([^\|]+)\|/", $query, $queryArray);
		for($i = 1; $i < sizeof($queryArray[0]); $i++) {
			preg_match("/itag=(?:5|17|18|22|34|35|36|37|38|43|44|45|46|82|84|102|104)/", $queryArray[1][$i], $itag);
			switch(preg_replace("/itag=/", Null, $itag[0])) {
				case 5:
					$quality = "Low Quality, 240p, FLV, 400x240";
					break;
				case 17:
					$quality = "Low Quality, 144p, 3GP, 0x0";
					break;
				case 18:
					$quality = "Medium Quality, 360p, MP4, 480x360";
					break;
				case 22:
					$quality = "High Quality, 720p, MP4, 1280x720";
					break;
				case 34:
					$quality = "Medium Quality, 360p, FLV, 640x360";
					break;
				case 35:
					$quality = "Standard Definition, 480p, FLV, 854x480";
					break;
				case 36:
					$quality = "Low Quality, 240p, 3GP, 0x0";
					break;
				case 37:
					$quality = "Full High Quality, 1080p, MP4, 1920x1080";
					break;
				case 38:
					$quality = "Original Definition, MP4, 4096x3072";
					break;
				case 43:
					$quality = "Medium Quality, 360p, WebM, 640x360";
					break;
				case 44:
					$quality = "Standard Definition, 480p, WebM, 854x480";
					break;
				case 45:
					$quality = "High Quality, 720p, WebM, 1280x720";
					break;
				case 46:
					$quality = "Full High Quality, 1080p, WebM, 1280x720";
					break;
				case 82:
					$quality = "Medium Quality 3D, 360p, MP4, 640x360";
					break;
				case 84:
					$quality = "High Quality 3D, 720p, MP4, 1280x720";
					break;
				case 102:
					$quality = "Medium Quality 3D, 360p, WebM, 640x360";
					break;
				case 104:
					$quality = "High Quality 3D, 720p, WebM, 1280x720";
					break;
				default:
					$quality = "transcoded (unknown) quality";
					break;
			}
			print "try this link -".$quality."- <a href=".$queryArray[1][$i].">".preg_replace("/[^\/]+\.googlevideo\.com/", "redirector.googlevideo.com", $queryArray[1][$i])."</a><br><br>\n";
		}
	}
?>
