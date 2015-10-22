c<? 
	include("includes/configuration.php");
	$filename=$_REQUEST['img'];
	header("Content-type: application/image");
    header("Content-Disposition:attachment; filename=$filename");
	readfile(DIR_PROOF_IMAGES.$filename);
?>