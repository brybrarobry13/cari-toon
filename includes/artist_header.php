<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta content="<?//=$_CONFIG[site_meta_keywords];?>" />
<meta content="<?//=$_CONFIG[site_meta_description];?>" />
<title><?//=$_CONFIG[site_title];?></title>
<link href="styles/style.css" rel="stylesheet" type="text/css" />-->
<?
include(DIR_INCLUDES."toons_seo.php");
$u_id= $_SESSION['sess_tt_uid'];
$url=explode("/",$_SERVER['PHP_SELF']);
$cnt=count($url);
$cnt--;
$page_name=$url[$cnt];

if($u_id)
{
	if(isset($_POST)&& $_POST['gal_status']!='')
	{
		$update="update `toon_users` set `artist_gallery_status`='".$_POST['gal_status']."' WHERE `user_id`=".$u_id;
		mysql_query($update);
	}
	$art_status_res=mysql_query("SELECT * FROM `toon_users` where user_id=".$u_id);
	$art_status_row=mysql_fetch_array($art_status_res);
}
//$_SERVER['HTTP_HOST']="http://www.toonsforu.com/";
$_SERVER['HTTP_HOST']="http://www.caricaturetoons.com/";
//$_SERVER['HTTP_HOST']="http://localhost/priswin/caricaturetoons/";
?>
<title><?=$seo_data[$page_name]['title'];?>-Triathlontoons</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="<?=$seo_data[$page_name]['description'];?>">
<meta name="keywords" content="<?=$seo_data[$page_name]['keywords'];?>">
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />

</head>
<script language="javascript" type="application/javascript">
function gal_show()
{
	document.form_gal_status.submit();
}
</script>
<body>
	<div id="outer_wrap">
		<!--header starts-->
		<div id="header">
			<div class="header_bg_color">
				<div  class="logo"><a href="<?=$_SERVER['HTTP_HOST']?>index.php"><img src="<?=$_SERVER['HTTP_HOST']?>images/logo.png" border="0"  /></a></div>
				<div class="header_menu" style="background-image:images/header_menu_artist.jpg">
                <form method="post" name="form_gal_status">
				<table style="vertical-align:middle;margin-top:80px;font-family:Arial, Helvetica, sans-serif;font-size:15px" border="0" cellspacing="10" cellpadding="0">
                	<tr>
                    	<td colspan="2">&nbsp;
                        <select name="gal_status" id="gal_status" onchange="gal_show();" 
						<? if($art_status_row['user_status']=='Inactive')echo "DISABLED"; ?>
						>
                        	<option value="Active" <? if($art_status_row['artist_gallery_status']=='Active') {?> selected="selected"<? } ?>>Show my gallery</option>
                            <option value="Inactive" <? if($art_status_row['artist_gallery_status']=='Inactive') {?> selected="selected"<? } ?>>Do not show my gallery</option>
                        </select>&nbsp;
                        </td>
					    <td>&nbsp;<a class="link_header_artist" href="<?=$_SERVER['HTTP_HOST']?>cusvidtut.php">Help / Videos</a></td>
						<? if(isloggedIn()){?>
							<td>&nbsp;<a class="link_header_artist" href="<?=$_SERVER['HTTP_HOST']?>logout.php"><b>Logout</b></a>&nbsp;</td>
						<? } ?>
                    </tr>
					<tr>
						<td><a class="link_header_artist" href="<?=$_SERVER['HTTP_HOST']?>art-hm.php">My Orders</a>&nbsp;</td>
						<td>&nbsp;<a class="link_header_artist" href="<?=$_SERVER['HTTP_HOST']?>art-gall.php?art_id=<?=$u_id?>">My Gallery</a>&nbsp;</td>
						<td>&nbsp;<a class="link_header_artist" href="<?=$_SERVER['HTTP_HOST']?>aproset.php?art_id=<?=$u_id?>">My account</a>&nbsp;</td>
                        <td>&nbsp;<a class="link_header_artist" href="<?=$_SERVER['HTTP_HOST']?>listout_artist_products.php?artist=<?=$u_id?>">My pricing</a>&nbsp;</td>
					</tr>
				</table>
                </form>
				</div>
			</div>
			<div class="headershadow">&nbsp;</div>
		</div>