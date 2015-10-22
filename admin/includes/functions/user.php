<?
function artist_gallery($user_id)
{
		$user_id=($user_id==NULL)?$_SESSION['sess_uid']:$user_id;
		$gallery_query = "SELECT * FROM `toon_artist_gallery` WHERE `user_id`='$user_id' ORDER BY `agal_code` DESC , `opro_image` DESC";
		$rs_gallery = mysql_query($gallery_query);
		$gallery_array = array();
		$index=0;
		while($row_gallery=mysql_fetch_assoc($rs_gallery))
		{
			$gallery_array[$index]=$row_gallery;
			$index++;
		}
		return $gallery_array;
}
	
function genRandomString()
{
	$length = 7;
	$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";
	$string="ID";

	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters)-1)];
	}
	return $string;
}
?>