<?php

	/**
	* @copyright Caricaturetoons
	* @author itekk LLC
	* @link http://www.caricaturetoons.com
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

	function imagettftextbox(&$image, $size, $angle, $left, $top, $color, $font, $text, $max_width)
	{
		
		$align=ALIGN_CENTER;
			$text_lines = explode("\n", $text); // Supports manual line breaks!
		   
			$lines = array();
			$line_widths = array();
		   
			$largest_line_height = 0;
		   
			foreach($text_lines as $block)
			{
				$current_line = ''; // Reset current line
			   
				$words = explode(' ', $block); // Split the text into an array of single words
			   
				$first_word = TRUE;
			   
				$last_width = 0;
			   
				for($i = 0; $i < count($words); $i++)
				{
					$item = $words[$i];
					$dimensions = imagettfbbox($size, $angle, $font, $current_line . ($first_word ? '' : ' ') . $item);
					$line_width = $dimensions[2] - $dimensions[0];
					$line_height = $dimensions[1] - $dimensions[7];
				   
					if($line_height > $largest_line_height) $largest_line_height = $line_height;
				   
					if($line_width > $max_width && !$first_word)
					{
						$lines[] = $current_line;
					   
						$line_widths[] = $last_width ? $last_width : $line_width;
					   
						/*if($i == count($words))
						{
							continue;
						}*/
					   
						$current_line = $item;
					}
					else
					{
						$current_line .= ($first_word ? '' : ' ') . $item;
					}
				   
					if($i == count($words) - 1)
					{
						$lines[] = $current_line;
					   
						$line_widths[] = $line_width;
					}
				   
					$last_width = $line_width;
					   
					$first_word = FALSE;
				}
			   
				if($current_line)
				{
					$current_line = $item;
				}
			}
		   
			$i = 0;
			foreach($lines as $line)
			{
				if($align == ALIGN_CENTER)
				{
					$left_offset = ($max_width - $line_widths[$i]) / 2;
				}
				elseif($align == ALIGN_RIGHT)
				{
					$left_offset = ($max_width - $line_widths[$i]);
				}
				imagettftext($image, $size, $angle, $left + $left_offset, $top, $color, $font, $line);
				$i++;
			}
		   
			return $largest_line_height * count($lines);
	}
	function imagettfstroke(&$image, $size, $angle, $left, $right, $top, $bottom, $color, $font, $text, $max_width)
	{		
		imagettftextbox($image, $size, $angle, $left, $top, $color, $font, $text,$max_width);
		imagettftextbox($image, $size, $angle, $right, $top, $color, $font, $text,$max_width);		
		imagettftextbox($image, $size, $angle, $left, $bottom, $color, $font, $text,$max_width);
		imagettftextbox($image, $size, $angle, $right, $bottom, $color, $font, $text,$max_width);
	}
	function imageHeight($fontsize)
	{
		$imgSize = ceil($fontsize*1.5)+$fontsize;
		return $imgSize;
	}
	function imageWidth($fontsize,$stringlength)
	{
		$imgWid = imageHeight($fontsize/2)*$stringlength;
		return $imgWid;
	}
?>