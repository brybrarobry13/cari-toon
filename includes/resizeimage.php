<?
function image_size($picture_name)
{
	//finds the size of the picture.....
	$mydata = getimagesize($picture_name);
	
	//returns the size factors.........
	return $mydata;
}

function print_image($name,$type,$width,$height,$alt,$title,$style="")
{
	if(preg_match('/\/admin/',$_SERVER['PHP_SELF']))
		$path = '../';
	else
		$path = '';
		
	switch($type)
	{
		case "artist": $path .= $_CONFIG["site_url"].'z_uploads/artist_gallery/thumb_artist_images/';
		break;
	}

	$name = $path.$name;

	if(is_dir($name))
	{
		$name.="noimage.gif";
	}
	elseif(!file_exists($name))
	{
		$pieces=explode('/',$name);
		$pieces[sizeof($pieces)-1]='noimage.gif';
		$name=implode('/',$pieces);
	}

	$property=image_size($name);//calling the function which finds the size of picture
	$p_width=$property[0]; //assigning the picture width //actual width of the image
	$p_height=$property[1]; //actual height of the image
	$nam=$name;
	
	if(($width<$p_width) and ($height<$p_height))
	{
		$xw = ($p_width / $width);
		$yh = ($p_height / $height);
		if ($xw > $yh)
		{
			$wd = $width;
			//$ht = $height;
			?><img src="<? echo $nam; ?>" border="0" alt="<? echo $alt;?>" title="<? echo $title;?>" width="<? echo $wd;?>"  style="<? echo $style;?>" /><?
		}
		else
		{
			//$wd = $width;
			$ht = $height;
			?><img src="<? echo $nam; ?>" border="0" alt="<? echo $alt;?>" title="<? echo $title;?>"  height="<? echo $ht;?>" style="<? echo $style;?>" /><?
		}
	}
	else if(($width < $p_width) && ($height>=$p_height))
	{
		//echo '<br>picture width exceeds';
		?><img src="<? echo $name; ?>" border="0" alt="<? echo $alt;?>" title="<? echo $title;?>" width="<? echo $width;?>" style="<? echo $style;?>" /><?
	}
	else if(($height<$p_height) && ($width>=$p_width))
	{
		//echo '<br>picture height exceeds ';
		?><img src="<? echo $nam; ?>" border="0" alt="<? echo $alt;?>" title="<? echo $title;?>" height=<?=$height;?> style="<? echo $style;?>" /><?
	}
	else
	{
		//echo '<br>picture is small enough';
		?><img src="<? echo $nam; ?>" border="0" alt="<? echo $alt;?>" title="<? echo $title;?>" style="<? echo $style;?>" /><? //if the height and width of the input image is greater than the actual size
	}
}
?>