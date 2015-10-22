<?php

	/**
	* @copyright Caricaturetoons
	* @author itekk LLC
	* @link http://www.toonsforu.com
	**/


	// Define Headers
	header("Content-type: image/png"); //Picture Format
	header("Expires: Mon, 01 Jul 2011 00:00:00 GMT"); // Past date
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Consitnuously modified
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Pragma: no-cache"); // NO CACHE*/
	/**
	* Image Related Functions
	**/
	
	include("functions/images.php");
	
	$text_str = ($_GET['text'])?base64_decode($_GET['text']):'TITLE NOT MENTIONED';
	$text_size = ($_GET['size'])?$_GET['size']:10;
	// Define the variables
	$textImg_font = "eict.ttf";
	$textImg_width = imageWidth($text_size,strlen($text_str));
	$textImg_height = imageHeight($text_size);
	
	// Set Co-ordinates
	$bluetext_bottom = floor($textImg_height - ($text_size/2));
	
	//Create Image of size $textImg_length x $textImg_height	
	$background = imagecreatetruecolor($textImg_width, $textImg_height);
	
	// Colors Used in the image
	$text_fontcolor = imagecolorallocate($background, 4, 75, 162);
	$text_shadowcolor = imagecolorallocate($background, 140, 140, 140);
	$text_strokecolor = imagecolorallocate($background, 255,255, 255);

	
	//Make it transparent
	imagesavealpha($background, true);
	$trans_colour = imagecolorallocatealpha($background, 0, 0, 0, 127);		
	imagefill($background, 0, 0, $trans_colour);
	
	// STRIP THE SLASHES IN THE TEXT
	$text_str = stripslashes($text_str);
	
	// FIRST PRINT THE SHADOW ON THE TRANSPARENT IMAGE
	imagettftextbox($background, $text_size, 0, -5, $bluetext_bottom + 4, $text_shadowcolor, $textImg_font, $text_str ,$textImg_width);
	
	// NOW GIVE WHITE STROKE THAT WILL BE SEEN AROUNT THE BLUE TEXT
	imagettfstroke($background, $text_size, 0, -3, 3, $bluetext_bottom - 2, $bluetext_bottom + 2, $text_shadowcolor, $textImg_font, $text_str ,$textImg_width);
	imagettfstroke($background, $text_size, 0, -3, 3, $bluetext_bottom - 2, $bluetext_bottom + 2, $text_strokecolor, $textImg_font, $text_str ,$textImg_width);
	
	// WRITE THE TEXT IN BLUE
	imagettftextbox($background, $text_size, 0, 0, $bluetext_bottom, $text_fontcolor, $textImg_font, $text_str ,$textImg_width);
	
	//Create image
	imagepng($background);
	
	//destroy image
	imagedestroy($background);	
?>