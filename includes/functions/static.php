<?
	function get_staticdetails($static_code)
	{
		$sql = "SELECT * FROM `toon_static` where `static_code`='$static_code'";
		$rs_static = mysql_query($sql);
		$static_row=mysql_fetch_assoc($rs_static);
		$static_content= stripslashes($static_row['static_content']);
		return $static_content;
	}
	
?>
