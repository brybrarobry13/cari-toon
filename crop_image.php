<script type="text/javascript">
	function setFormValues(new_file_name)
	{
	 
	 if(new_file_name.substr(0,5)=='befor')
	 {
		window.opener.document.getElementById("cropped_1").value="yes";
	 }
	 if(new_file_name.substr(0,5)=='after')
	 {
		window.opener.document.getElementById("cropped_2").value="yes";
	 }
	 
	}
</script>

<?php
/*echo "<pre>";
print_r($_GET);*/
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	//print_r($_POST);
	$file_ext = substr(basename( $_GET['image_name']), strrpos(basename( $_GET['image_name']), '.') + 1);
    //echo $file_ext;
    $src_w = $_GET['width'];
	$src_h = $_GET['height'];
	
	 $targ_w = 204;
	$targ_h = 255;
    $jpeg_quality = 90;

    $src = 'z_uploads/artist_gallery/thumb_artist_images/temp_'.$_GET['image_name'];
	
	if($file_ext=="jpg" || $file_ext=="jpeg")
	{
		//header('Content-type: image/jpeg');
    	$img_r = imagecreatefromjpeg($src);
    }
	if($file_ext=="png")
	{
		//header('Content-type: image/png');
    	$img_r = imagecreatefrompng($src);
    }
	if($file_ext=="gif")
	{
		//header('Content-type: image/gif');
    	$img_r = imagecreatefromgif($src);
    }
	
	 	  $old_height=imagesy($img_r);
		  $old_width=imagesx($img_r);
		  
		  if($old_height>$old_width)
		  {
		  	$box_side=$old_width;
		  }
		  else
		  {
		  	$box_side=$old_height;
		  }
    
    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	//imagealphablending($dst_r, false);
	$black = imagecolorallocate($dst_r, 0, 0, 0);
	imagecolortransparent($dst_r, $black);

	if($_GET['direction']=='hor')
	{
    	imagecopyresampled($dst_r,$img_r,0,0,0,0,$targ_w,$targ_h,$src_w,$src_h);
	}
	else
	{
		imagecopyresampled($dst_r,$img_r,0,0,0,0,$targ_w,$targ_h,$src_w,$src_h);
	}
	$crop_target='z_uploads/artist_gallery/thumb_artist_images/th_'.$_GET['image_name'];
     
    
	if($file_ext=="jpg" || $file_ext=="jpeg")
	{
		//header('Content-type: image/jpeg');
    	imagejpeg($dst_r,$crop_target,$jpeg_quality);
    }
	if($file_ext=="png")
	{
		//header('Content-type: image/png');
    	imagepng($dst_r,$crop_target);
    }
	if($file_ext=="gif")
	{
		//header('Content-type: image/gif');
    	imagegif($dst_r,$crop_target);
    }
	
 }
	//echo $_GET['image_name'];
	@unlink($src);
?>
	


	
	
	<script type="text/javascript">
	 setFormValues('<?php echo $_GET['image_name'];?>');
	 window.close();
	</script>
	
	

