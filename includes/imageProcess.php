<?php
require_once('configuration.php');
ini_set("memory_limit","2000M");
# Constants
define(DEFAULT_IMAGE,'noimage.gif');
$imagetype=$_GET['type'];
switch($imagetype)
{
	case 'artist':define(IMAGE_BASE,DIR_ARTIST_GALLERY);break;
	case 'cart' : define(IMAGE_BASE,DIR_CART_IMAGES);break;
	case 'proof' : define(IMAGE_BASE,DIR_PROOF_IMAGES);break;
	case 'review' : define(IMAGE_BASE,DIR_PROOF_IMAGES);break;
	case 'messaging' : define(IMAGE_BASE,DIR_MESSAGING_IMAGES);break;
	case 'caricature' : define(IMAGE_BASE,DIR_CARICATURE_IMAGES);break;
	case 'ezprints' : define(IMAGE_BASE,DIR_EZPRINTS_IMAGES);break;
	case 'profile' : define(IMAGE_BASE,DIR_PROFILE_IMAGES);break;
	case 'coupon' : define(IMAGE_BASE,DIR_COUPON_IMAGES);break;
	case 'coollink' : define(IMAGE_BASE,DIR_COOL_LINK_IMAGES);break;
	case 'ez_category' : define(IMAGE_BASE,DIR_EZPRINTS_CAT_IMAGES);break;
	case 'sample_image' : define(IMAGE_BASE,DIR_SAMPLE_IMAGES);break;
	
}
# Get image location
$image_file = $_GET['image'];
$filesize=$_GET['size'];
if($filesize)
{
	define(MAX_HEIGHT, $filesize);
	define(MAX_WIDTH, $filesize);
}
else
{
	define(MAX_HEIGHT, 90);
	define(MAX_WIDTH, 90);
}
$image_path = IMAGE_BASE.$image_file;
if(!file_exists($image_path) || is_dir($image_path))
	$image_path = IMAGE_BASE.DEFAULT_IMAGE;

# Load image
$img = null;
$ext = strtolower(end(explode('.', $image_path)));
if ($ext == 'jpg' || $ext == 'jpeg') {
    $img = @imagecreatefromjpeg($image_path);
} else if ($ext == 'png') {
    $img = @imagecreatefrompng($image_path);
# Only if your version of GD includes GIF support
}
else if ($ext == 'gif') {
    $img = @imagecreatefromgif($image_path);
# Only if your version of GD includes GIF support
}
else if ($ext == 'bmp') {
    $img = imagecreatefrombmp($image_path);
# Only if your version of GD includes GIF support
}
else if ($ext == 'tif') {
    $img = imagecreatefromtif($image_path);
# Only if your version of GD includes GIF support
}

# If an image was successfully loaded, test the image for size
if ($img) {

    # Get image size and scale ratio
    $new_width = $width = imagesx($img);
    $new_height = $height = imagesy($img);
    $scale = min(MAX_WIDTH/$width, MAX_HEIGHT/$height);
	

    # If the image is larger than the max shrink it
    if ($scale <= 1) {
        $new_width = floor($scale*$width);
        $new_height = floor($scale*$height);
		
        # Create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);
		imagealphablending($tmp_img, true);
		imagesavealpha($tmp_img,true);
		$transparent = imagecolorallocatealpha($tmp_img, 255, 255, 255, 0);
		imagefilledrectangle($tmp_img, 0, 0, $new_width, $new_height, $transparent);

        # Copy and resize old image into new image
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0,
                         $new_width, $new_height, $width, $height);
        imagedestroy($img);
        $img = $tmp_img;
    }
}

# Create error image if necessary
if (!$img) {
# Get image location
$image_file = $_GET['image'];
$image_path = IMAGE_BASE.DEFAULT_IMAGE;

# Load image
$img = null;
$ext = strtolower(end(explode('.', $image_path)));
if ($ext == 'jpg' || $ext == 'jpeg') {
    $img = @imagecreatefromjpeg($image_path);
} else if ($ext == 'png') {
    $img = @imagecreatefrompng($image_path);
# Only if your version of GD includes GIF support
}

# If an image was successfully loaded, test the image for size
if ($img) {

    # Get image size and scale ratio
    $width = imagesx($img);
    $height = imagesy($img);
    $scale = min(MAX_WIDTH/$width, MAX_HEIGHT/$height);

    # If the image is larger than the max shrink it
    if ($scale < 1) {
        $new_width = floor($scale*$width);
        $new_height = floor($scale*$height);

        # Create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        # Copy and resize old image into new image
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0,$new_width, $new_height, $width, $height);
        imagedestroy($img);
        $img = $tmp_img;
    }
}
}
if($_REQUEST['type']=='proof'){
	imagealphablending($img, true);
	$watermark = imagecreatefrompng('../images/proof_watermark.png');
	$watermark_width = imagesx($watermark);  
	$watermark_height = imagesy($watermark);
	$image = $img;   
	if($new_height < $watermark_height || $new_width < $watermark_width)
	{
		$new_watermark_width = $new_watermark_height = min($new_width,$new_height);
		$dest_x = ($new_width - $new_watermark_width)/2;
		$dest_y = ($new_height- $new_watermark_height)/2;// 
		$pro_scale=0;
		if($scale<1)
			$pro_scale=0;
		$watermark_width = $new_watermark_width+$pro_scale;  
		$watermark_height = $new_watermark_height+$pro_scale;
		/*for($dest_from=0;$dest_from-$watermark_width<$new_width;$dest_from=$dest_from+$watermark_width)
		{
			imageComposeAlpha( $image, $watermark,$dest_from, 0, $watermark_width, $watermark_height );
		}
		for($dest_from=0;$dest_from-$watermark_height<$new_height;$dest_from=$dest_from+$watermark_height)
		{
			imageComposeAlpha( $image, $watermark, 0,$dest_from, $watermark_width, $watermark_height );
		}*/
		imageComposeAlpha( $image, $watermark, $dest_x,$dest_y, $watermark_width, $watermark_height );
	}
	else
	{
		
		$dest_x = ($new_width - $watermark_width)/2;
		$dest_y = ($new_height- $watermark_height)/2;// -100;
		imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);  
	}}
	
	if ($img) {

    # Get image size and scale ratio
    $width = imagesx($img);
    $height = imagesy($img);
    $scale = min(MAX_WIDTH/$width, MAX_HEIGHT/$height);
    # If the image is larger than the max shrink it
    if ($scale < 1) {
        $new_width = floor($scale*$width);
        $new_height = floor($scale*$height);

        # Create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        # Copy and resize old image into new image
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0,
                         $new_width, $new_height, $width, $height);
        imagedestroy($img);
        $img = $tmp_img;

    }
}
# Display the image
if($img)
{
	if ($ext == 'jpg' || $ext == 'jpeg') {
		@header("Content-type: image/jpeg");
   		@imagejpeg($img);
	} else if ($ext == 'png') {
		@header("Content-type: image/png");
   		@imagepng($img);
	# Only if your version of GD includes GIF support
	}
	else if ($ext == 'gif') {
		@header("Content-type: image/gif");
   		@imagegif($img);
	# Only if your version of GD includes GIF support
	}
	else if ($ext == 'bmp') {
		@header("Content-type: image/bmp");
   		@imagebmp($img);
	# Only if your version of GD includes GIF support
	}
	else if ($ext == 'tif') {
		@header("Content-type: image/tif");
   		@imagetif($img);
	# Only if your version of GD includes GIF support
	}

	
}
else
{
	print "$image_path";
}

/**
* Compose a PNG file over a src file.
* If new width/ height are defined, then resize the PNG (and keep all the transparency info)
* Author: Alex Le - http://www.alexle.net
*/
function imageComposeAlpha( &$src, &$ovr, $ovr_x, $ovr_y, $ovr_w = false, $ovr_h = false)
{
	if( $ovr_w && $ovr_h )
	$ovr = imageResizeAlpha( $ovr, $ovr_w, $ovr_h );
	
	/* Noew compose the 2 images */
	imagecopy($src, $ovr, $ovr_x, $ovr_y, 0, 0, imagesx($ovr), imagesy($ovr));
}

/**
* Resize a PNG file with transparency to given dimensions
* and still retain the alpha channel information
* Author: Alex Le - http://www.alexle.net
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
	//imagecopyresized($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
	/* use imagecopyresampled if you concern more about the quality */
	imagecopyresampled($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
	return $temp;
}





///* Open the photo and the overlay image */
//$photoImage = ImageCreateFromJPEG('images/MiuMiu.jpg');
//$overlay = ImageCreateFromPNG('images/hair-trans.png');
//
//$percent = 0.8;
//$newW = ceil(imagesx($overlay) * $percent);
//$newH = ceil(imagesy($overlay) * $percent);
//
///* Compose the overlay photo over the target image */
//imageComposeAlpha( $photoImage, $overlay, 86, 15, $newW, $newH );
//
///* Open another PNG file, then resize and compose it */
//$watermark = imagecreatefrompng('images/watermark.png');
//imageComposeAlpha( $photoImage, $watermark, 10, 20, imagesx($watermark)/2, imagesy($watermark)/2 );
//
///**
//* Open the same PNG file then compose without resizing
//* As the original $watermark is passed by reference, it was resized already.
//* So we have to reopen it.
//*/
//$watermark = imagecreatefrompng('images/watermark.png');
//imageComposeAlpha( $photoImage, $watermark, 80, 350);
//Imagepng($photoImage); // output to browser
//
//ImageDestroy($photoImage);
//ImageDestroy($overlay);
//ImageDestroy($watermark);
?>
