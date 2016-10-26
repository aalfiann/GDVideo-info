<?php
	require_once("curl.php");
	$VideoScreenshot = "https://drive.google.com/vt?id=".$_SERVER["QUERY_STRING"];
	if(preg_match("/errorcode=100/", $response_data) || strlen($_SERVER["QUERY_STRING"])!= "28"){
		echo "請輸入正確的影片辨識碼。";
	} elseif(preg_match("/errorcode=100/", $response_data)) {
		echo "這部影片不存在。";
	} elseif(preg_match("/errorcode=150/", $response_data)) {
		echo '<img src=".'$VideoScreenshot.'"><br>';
		echo "您沒有這部影片的存取權限。";
	} else {
		echo '<img src="'.$VideoScreenshot.'"><br>"';
		preg_match_all("/([^\|]+)\|/", $response_data, $VideoSource);
		$VideoName = preg_replace("/&BASE_URL.*/", Null, preg_replace("/.*title=/", Null, $response_data));
		for($i = 1; $i < sizeof($VideoSource[0]); $i++) {
			$VideoSource[1][$i] = preg_replace("/[^\/]+\.googlevideo\.com/", "redirector.googlevideo.com", $VideoSource[1][$i]);
			preg_match("/itag=(?:5|17|18|22|34|35|36|37|38|43|44|45|46|82|84|102|104)/", $VideoSource[1][$i], $itag);
			switch(preg_replace("/itag=/", Null, $itag[0])) {
				case 5:
					$QualityString = "Low Quality, 240p, FLV, 400x240";
					break;
				case 17:
					$QualityString = "Low Quality, 144p, 3GP, 176x144";
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
			echo "[".$i."] ".$VideoName."<br>".$QualityString."<br><a href=".$VideoSource[1][$i].">".$VideoSource[1][$i]."</a><br><br>";
		}
	}