<?php


header("Content-Type: image/png"); //Setcontent Type as image
putenv('GDFONTPATH=' . realpath('.')); 
//NOTE FONTS ARE IN ROOT FOLDER WITH THIS SCRIPT
$font = 'Vera'; //Declare font for banner
$fontmc = 'Minecraft'; //Declare secondary font for Server Name
include_once 'MinecraftServerStatus/status.class.php'; //Include the status class
$status = new MinecraftServerStatus(); //Create a new Server Status Object
$response = $status->getStatus('ultimate.brumicon.com', 25565); //Poll server for response

//AVAILABLE RESPONSES IF SERVER IS ONLINE ARE:
//$response['hostname'] Hostname/IP of Server
//$response['version'] Version Number of Server
//$response['players'] Current number of players online
//$response['maxplayers'] Max players online
//$response['motd'] MOTD of the Server 
//$response['ping'] Ping time to the server, may be higher than expected.

if(!$response) { //Responce=False, server is offline
		$online="OFFLINE";
		$im = @imagecreate(400, 110) //Create overlay image
		or die("Cannot Initialize new GD image stream"); 
		$background_color = imagecolorallocate($im, 255, 255, 255); //Set background to white (Later convert to transparent)
		$black = imagecolorallocate($im, 255, 255, 254); //Set text color
		$green = imagecolorallocate($im, 124, 252, 0); //Set the online text color
		$red = imagecolorallocate($im, 255, 0, 0); //Set the offline text color
		imagecolortransparent($im, $background_color); // Make the $background_color Transparent
		imagettftext($im, 15, 0, 2, 20, $black, $fontmc, "ULTIMATE BRUMICON"); //Name of server
		imagettftext($im, 10, 0, 2, 40, $black, $font, "Version:"); //Version text
		imagettftext($im, 10, 0, 55, 40, $black, $font, "NA"); //Server offline write NA
		imagettftext($im, 10, 0, 2, 60, $black, $font, "Players:"); //Players Text
		imagettftext($im, 10, 0, 55, 60, $black, $font, "0"); //Server offline write 0
		imagettftext($im, 12, 0, 2, 80, $black, $font, "Website: http://minecraft.brumicon.com"); //Write Server Website
		imagettftext($im, 10, 0, 2, 100, $red, $font, $online); //Write the offline string
		imagepng($im); //Create PNG Image
		imagedestroy($im); //Clear memory
	} else { //Responce<>False, server is online
		$online="ONLINE";
		$players = $response['players']; //Pull number of player from query
		$im = @imagecreate(400, 110) //Create overlay image
		or die("Cannot Initialize new GD image stream"); 
		$background_color = imagecolorallocate($im, 255, 255, 255); //Set background to white (Later convert to transparent)
		$black = imagecolorallocate($im, 255, 255, 254); //Set text color
		$green = imagecolorallocate($im, 124, 252, 0); //Set the online text color
		$red = imagecolorallocate($im, 255, 0, 0); //Set the offline text color
		$str1="/"; 
		$string=$response['players'].$str1.$response['maxplayers']; //Create player numbers (x/y)
		imagecolortransparent($im, $background_color);
		imagettftext($im, 15, 0, 2, 20, $black, $fontmc, "ULTIMATE BRUMICON");//Name of server
		imagettftext($im, 10, 0, 2, 40, $black, $font, "Version:");//Version text
		imagettftext($im, 10, 0, 55, 40, $black, $font, $response['version']); //Pull Version from Query
		imagettftext($im, 10, 0, 2, 60, $black, $font, "Players:");//Write players text
		imagettftext($im, 10, 0, 55, 60, $black, $font, $string);//Write number of players(x/y)
		imagettftext($im, 12, 0, 2, 80, $black, $font, "Website: http://minecraft.brumicon.com"); //Write Server Website
		imagettftext($im, 10, 0, 2, 100, $green, $font, $online);//Write the online string
		imagepng($im); //Create PNG Image
		imagedestroy($im); //Clear memory
	}
	
?>
