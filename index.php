<?php
# Curl
	$URL = "https://drive.google.com/get_video_info?docid=".$_SERVER["QUERY_STRING"];		// FileID in URL
	if (strlen($_SERVER["QUERY_STRING"]) != "28") {						// Error IF(NotExist) and CorrectID = 28 Character
		echo "這部影片不存在。例：<a href='/?0B757HvrhbFeienJaWnFfWGtQYUU'> http://www.domain.com/?0B757HvrhbFeienJaWnFfWGtQYUU</a>";		// Error Text(NotExist)
	}else{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//		curl_setopt($curl, CURLOPT_PROXY, "proxy.hinet.net:80");		// Proxy
//		curl_setopt($curl, CURLOPT_PROXYUSERPWD, ":");					// If Need Username:Password
		curl_setopt($curl, CURLOPT_URL, $URL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response_data = curl_exec($curl);
//		echo 'Curl error: ' . curl_error($curl); 						// Curl Error Information
		curl_close($curl);												// Close Curl
# GetInfo
# Get VideoName
		if(preg_match("/您沒有這部影片的存取權限/", urldecode(urldecode($response_data)))){				// Error IF(Permissions)
			echo "您沒有這部影片的存取權限。";															// Error Text(Permissions)
		}else{
			$VideoName = preg_replace("/&BASE_URL.*/", Null, preg_replace("/.*title=/", Null, urldecode(urldecode($response_data))));		// Give VideoName
		}
# Get VideoScreenshot
		$VideoScreenshot = "https://drive.google.com/vt?id=".$_SERVER["QUERY_STRING"];					// Give VideoScreenshot
		echo "<image src='https://drive.google.com/vt?id=".$_SERVER["QUERY_STRING"]."'><br>";
# Get VideoSource
		preg_match_all("/([^\|]+)\|/", urldecode(urldecode($response_data)), $VideoSource);				// Give VideoSource
		for($i = 1; $i < sizeof($VideoSource[0]); $i++) {
			preg_match("/itag=(?:5|17|18|22|34|35|36|37|38|43|44|45|46|82|84|102|104)/", $VideoSource[1][$i], $itag);
			switch(preg_replace("/itag=/", Null, $itag[0])) {
				case 5:
					$QualityString = "Low Quality, 240p, FLV, 400x240";
					break;
				case 17:
					$QualityString = "Low Quality, 144p, 3GP, 0x0";
					break;
				case 18:
					$QualityString = "Medium Quality, 360p, MP4, 480x360";
					break;
				case 22:
					$QualityString = "High Quality, 720p, MP4, 1280x720";
					break;
				case 34:
					$QualityString = "Medium Quality, 360p, FLV, 640x360";
					break;
				case 35:
					$QualityString = "Standard Definition, 480p, FLV, 854x480";
					break;
				case 36:
					$QualityString = "Low Quality, 240p, 3GP, 0x0";
					break;
				case 37:
					$QualityString = "Full High Quality, 1080p, MP4, 1920x1080";
					break;
				case 38:
					$QualityString = "Original Definition, MP4, 4096x3072";
					break;
				case 43:
					$QualityString = "Medium Quality, 360p, WebM, 640x360";
					break;
				case 44:
					$QualityString = "Standard Definition, 480p, WebM, 854x480";
					break;
				case 45:
					$QualityString = "High Quality, 720p, WebM, 1280x720";
					break;
				case 46:
					$QualityString = "Full High Quality, 1080p, WebM, 1280x720";
					break;
				case 82:
					$QualityString = "Medium Quality 3D, 360p, MP4, 640x360";
					break;
				case 84:
					$QualityString = "High Quality 3D, 720p, MP4, 1280x720";
					break;
				case 102:
					$QualityString = "Medium Quality 3D, 360p, WebM, 640x360";
					break;
				case 104:
					$QualityString = "High Quality 3D, 720p, WebM, 1280x720";
					break;
				default:
					$QualityString = "transcoded (unknown) quality";
					break;
			}
			echo "[".$i."] ".$VideoName."<br>".$QualityString."<br><a href=".$VideoSource[1][$i].">".preg_replace("/[^\/]+\.googlevideo\.com/", "redirector.googlevideo.com", $VideoSource[1][$i])."</a><br><br>";
		}
	}
?>
