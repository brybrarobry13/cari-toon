<?
$filename=$_REQUEST['image'];
header("Content-type: application/image");
header("Content-Disposition:attachment; filename=$filename");
readfile("z_uploads/messaging_images/".$filename);
?>
