<?
$filename=$_REQUEST['f_name'];
header("Content-type: application/image");
header("Content-Disposition:attachment; filename=$filename");
readfile("z_uploads/cart_images/".$filename);
?>
