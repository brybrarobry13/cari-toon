<?php

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
		$imgWid = imageHeight($fontsize/1.8)*$stringlength;
		return $imgWid;
	}
	
	/**
	* Resize a PNG file with transparency to given dimensions
	* and still retain the alpha channel information
	*/
	function imageResizeAlpha(&$src, $w, $h)
	{
		/* create a new image with the new width and height */
		$temp = imagecreatetruecolor($w, $h);
		
		/* making the new image transparent */
		$background = imagecolorallocate($temp, 0, 0, 0);
		ImageColorTransparent($temp, $background); // make the new temp image all transparent
		imagealphablending($temp, false); // turn off the alpha blending to keep the alpha channel
		
		/* Resize the PNG file */
		/* use imagecopyresized to gain some performance but loose some quality */
		imagecopyresized($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		/* use imagecopyresampled if you concern more about the quality */
		//imagecopyresampled($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		return $temp;
	}

?>