
<?php
/*echo "<pre>";
print_r($_GET);*/
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	//print_r($_POST);
	$file_ext = substr(basename( $_GET['image_name']), strrpos(basename( $_GET['image_name']), '.') + 1);
    //echo $file_ext;
    $targ_w = $_GET['width'];
	$targ_h = $_GET['height'];
    $jpeg_quality = 90;

    $src = '../../z_uploads/admin_artist_gallery/artist_images/for_crop_'.$_GET['image_name'];
	
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
    
    $dst_r = imagecreatetruecolor( $targ_w, $targ_h );
	
	$black_2 = imagecolorallocate($dst_r, 0, 0, 0);
	imagecolortransparent($dst_r, $black_2);

	if($_GET['direction']=='hor')
	{
    	imagecopyresampled($dst_r,$img_r,0,0,$_GET['from'],0,$targ_w,$targ_h,$targ_w,$targ_h);
	}
	else
	{
		imagecopyresampled($dst_r,$img_r,0,0,0,$_GET['from'],$targ_w,$targ_h,$targ_w,$targ_h);
	}
	$crop_target='../../z_uploads/admin_artist_gallery/thumb_artist_images/temp_'.$_GET['image_name'];
     
    
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
	echo $_GET['image_name'];
?>
	

