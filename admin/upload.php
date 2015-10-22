<script language="javascript" type="text/javascript">
function create_temp(left_pos_clip,img_name,cr_type,box_width,box_height)
{
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		}
	}
	xmlhttp.open("GET","templates/crop_ajax.php?direction="+cr_type+"&from="+left_pos_clip+"&width="+box_width+"&height="+box_height+"&image_name="+img_name,true);
	xmlhttp.send();
}
</script>
<?php 
	//session_start();
    $destination_path = getcwd().DIRECTORY_SEPARATOR."../z_uploads/admin_artist_gallery/artist_images/";
   
  //$destination_path = "z_uploads/ok/"
   $result = 0;
   
   
   $ext_array = array("jpg","gif","png","jpeg");
   $file_ext = strtolower(substr(basename( $_FILES['myfile']['name']), strrpos(basename( $_FILES['myfile']['name']), '.') + 1));
   if(!in_array($file_ext,$ext_array))
   {
   		$result = 0;
   }
   else
	{
		 	$photoName1 = str_replace(" ","_",basename( $_FILES['myfile']['name']));
			$photoName2 = str_replace("'","_",$photoName1);

		    $new_file_name_with_type=strtolower($_GET['type']."_".$photoName2) ;
		    $target_path = $destination_path .$new_file_name_with_type;
		    if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path))
			{
				
			 
			 // $image->load($target_path);
			  /*$image->resize(816,616);
			  $image->save($destination_path."for_crop_". basename( $_FILES['myfile']['name']));*/
			  
			  $image_info = getimagesize($target_path);
			  $image_type = $image_info[2];
			  
			   if( $image_type == IMAGETYPE_JPEG ) {
				
				 $image = imagecreatefromjpeg($target_path);
			  } elseif( $image_type == IMAGETYPE_GIF ) {
		 
				 $image = imagecreatefromgif($target_path);
			  } elseif( $image_type == IMAGETYPE_PNG ) {
		 
				 $image = imagecreatefrompng($target_path);
			  }
		   
		   	  
			  
			  $old_height=imagesy($image);
			  $old_width=imagesx($image);
			  if($old_height < 255 || $old_width < 204 )
			  {?>
			  <script type="text/javascript">alert("Minimum image resolution is 204 x 255");</script>
			  <?php
			  
			  }
			  else
			  {
				  	
					if($old_height > $old_width)
					{
					  	if($old_height >= 800)
					  	{	
						 	$height=800;
						 	$width=((800*$old_width)/$old_height);
					  	}
						else
						{
							$width=$old_width;
							$height=$old_height;
						}
					 } 
					 else
					 {	
					 	if($old_width >= 900)
						{
						 	$width=900;
							$height=((900*$old_height)/$old_width);
						}
						else
						{
							$width=$old_width;
							$height=$old_height;
						}
					 }
					 
					  $new_image = imagecreatetruecolor($width, $height);
					  imagealphablending($new_image, false);
					  
					  $black_1 = imagecolorallocate($new_image, 0, 0, 0);
					  imagecolortransparent($new_image, $black_1);
					  
					  
					  $crop_target="../z_uploads/admin_artist_gallery/artist_images/".$new_file_name_with_type;
					  
					  $stat=imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $old_width, $old_height);
					 
					  if($image_type == IMAGETYPE_JPEG)
					  {
						imagejpeg($new_image,$crop_target,75);
						$image_1 = imagecreatefromjpeg($target_path);
					  }
					  elseif($image_type == IMAGETYPE_GIF)
					  {
						imagegif($new_image,$crop_target);
						 $image_1 = imagecreatefromgif($target_path);
					  }
					  elseif($image_type == IMAGETYPE_PNG)
					  {
						imagepng($new_image,$crop_target);
						$image_1 = imagecreatefrompng($target_path);
					  }
					  
					 
					$old_height=imagesy($image_1);
			  		$old_width=imagesx($image_1);
					
					
					
					if($old_width <= $old_height)
					{
					  	/*if($old_height >= 400)
					  	{	
						 	$height=400;
						 	$width=((400*$old_width)/$old_height);
					  	}
						else
						{
							$width=$old_width;
							$height=$old_height;
						}*/
						$dir="ver";
						$width=204;
						$height=((204*$old_height)/$old_width);
					 } 
					 else
					 {	
					 	
							
							$dir="hor";
						 	$height=255;
							$width=((255*$old_width)/$old_height);
						
					 }
					  $box_width=$width;
					  $box_height=$height;
					  
					  $image_1 = imagecreatetruecolor($width, $height);
					  imagealphablending($image_1, false);
					  
					  $black_2 = imagecolorallocate($image_1, 0, 0, 0);
					  imagecolortransparent($image_1, $black_2);
					  
					  
					  $crop_target="../z_uploads/admin_artist_gallery/artist_images/for_crop_".$new_file_name_with_type;
					  
					  $stat=imagecopyresampled($image_1, $new_image, 0, 0, 0, 0, $width, $height, $old_width, $old_height);
					 
					  if($image_type == IMAGETYPE_JPEG)
					  {
						imagejpeg($image_1,$crop_target,75);
					  }
					  elseif($image_type == IMAGETYPE_GIF)
					  {
						imagegif($image_1,$crop_target);
					  }
					  elseif($image_type == IMAGETYPE_PNG)
					  {
						imagepng($image_1,$crop_target);
					  }
					  //@move_uploaded_file($target_path, $crop_target);
					  ?>
					  <script type="text/javascript">
					  create_temp(0,'<?php echo $new_file_name_with_type;?>','<?php echo $dir;?>',<?php echo $box_width;?>,<?php echo $box_height;?>);
					  </script>
					  <?php
					  
					  $result = 1;
			  }
			  
		   }
	}
   sleep(1);
?>
<script type="text/javascript">window.top.window.stopUpload(<?php echo $result.",'".$new_file_name_with_type."'"?>);</script>
