<? require_once('mcapi/inc/MCAPI.class.php');
//Caricature MailChimp Key
$apikey = 'd7229a6dbbe5df2b5bb2f6430fdbefd4-us2';

if(isset($_POST['join_x']))
{
	$email_news=$_POST['email_news'];
	mysql_query ("INSERT INTO `toon_newsletter` (`nltr_email`) VALUES ('$email_news')");
	
	$api = new MCAPI($apikey);
	
	#List Id of Caricature Toons
	$listID = 'dbde0db1cb';
	
	if($api->listSubscribe($listID, $email_news) === true) 
	{
		// It worked!
		$msg='* Please check your email to confirm registration';		
	}
	else
	{
		// An error ocurred, return error message
		$msg='Error: ' . $api->errorMessage;	
	}
}

$getuserDetails = getUserDetails($user_id);
if($getuserDetails['utype_id']==2)
{
	header("Location:art-hm.php");
	exit();
}
include(DIR_INCLUDES."toons_seo.php");
//echo $_CONFIG[site_meta_keywords];
$_SERVER['HTTP_HOST']="http://www.caricaturetoons.com/";
//$_SERVER['HTTP_HOST']="http://www.toonsforu.com/";
//$_SERVER['HTTP_HOST']="http://localhost/priswin/caricaturetoons/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta content="<?//=$_CONFIG[site_meta_keywords];?>" />
<meta content="<?//=$_CONFIG[site_meta_description];?>" />
<title><?//=$_CONFIG[site_title];?></title>-->
<? 
	$url=explode("/",$_SERVER['PHP_SELF']);
	$cnt=count($url);
	$cnt--;
	$page_name=$url[$cnt];

	$url1=explode("artist/",$_SERVER['REQUEST_URI']);
	$url2=explode("/",$url1[1]);
	if($url2[0]!='')
	{
		$sql=mysql_query("SELECT `user_fname` FROM `toon_users` WHERE `user_id`=".$url2[0]);
		$res=mysql_fetch_assoc($sql);
		$fname=$res['user_fname'];
	}

	$meta_url1=explode("/caricatures/toons-ideas/gallery/",$_SERVER['REQUEST_URI']);
	if($meta_url1[1]!='')
	{
		$metasql=mysql_query("SELECT * FROM `toons_ideas` WHERE `ti_ref_link`='".$meta_url1[1]."'");
		$metares=mysql_fetch_assoc($metasql);
	}
?>

<?php if($_SERVER['REQUEST_URI']=="/"){ ?>
<title>Caricatures From Photos, Custom Caricatures, Caricature Rhode Island, Phoenix Caricature Artists</title>

<meta name="description" content="Caricature Toons create Caricatures and Cartoons from photos at great prices. Sign Up here and Caricature yourself. Wedding caricatures, custom caricatures, phoenix caricature artists, political caricatures family caricatures, famous caricature artists." />

<meta name="keywords" content="Caricatures from Photos, custom caricatures, caricature rhode island, phoenix caricature artists, caricature artist calgary, caricature yourself from a photo, hockey player caricature from my photo, caricature photo for present, caricature pictures from a photo" />
<?php }elseif($_SERVER['REQUEST_URI']=="/order-caricature.php"){ ?>
<title>Order Caricature Toons, Downloadable Caricature, Caricature Portraits Online - Caricaturetoons.Com</title>

<meta name="description" content="Caricature Toons offer some of the highest quality caricatures you can order online at better than affordable prices. All our Caricatures are hand-drawn, many making use of the latest digital technology. We offer caricature toons, downloadable caricature, caricature from photo on aprons, caricature portraits online and more." />

<meta name="keywords" content="caricature toons, order caricature online, caricatures online, caricatures from photos, downloadable caricature, cariactures from photos, caricature from photo on aprons, caricature online photo, caricature portraits online" />
<?php }elseif($_SERVER['REQUEST_URI']=="/contact.php"){ ?>
<title>Contact - Caricaturetoons.Com</title>

<meta name="description" content="At Caricature Toons we aim to please and want to make sure your 100% Satisfied with your Caricature Toon. If you require any assistance and Caricature Artist, please do not hesitate to email us and we'll promptly get back to you." />

<meta name="keywords" content="caricature yourself, Buy caricatures online, caricatures from photos, cartoon artist, cartoon caricature products, caricature artist, cartoon people, drawing cartoons, photo to cartoon, football cartoons, soccer cartoons, baseball cartoons, fishing cartoons, caricature drawing,  caricature gift" />

<?php }elseif($_SERVER['REQUEST_URI']=="/special-deals.php"){ ?>
<title>Caricature Toons, hand painted caricature - Caricaturetoons</title>

<meta name="description" content="Check out our coupons, deals and special caricatures and Hand painted caricature offers as well as other great deals. Refer friends from here and Subscribe for newsletter and daily updates." />

<meta name="keywords" content="caricature yourself, caricatures online,hand painted caricature, caricatures from photos, cartoon artist, cartoon caricature, Cartoonist, online caricature, caricature artists, online caricature, drawing cartoons, Style & Price, coupons" />

<?php }elseif($_SERVER['REQUEST_URI']=="/buy-caricature-gift.php"){ ?>
<title>Caricature Gifts - Caricaturetoons.Com</title>

<meta name="description" content="With caricature toons, we can provide you with some funky caricature toon gifting options that are truly unique. our caricature cartoons made a huge splash and are an absolute cherished hit with caricature gifts and more." />

<meta name="keywords" content="caricature toons, caricature gifts, caricatures online,hand painted caricature, caricatures from photos, cartoon artist" />

<?php }elseif($_SERVER['REQUEST_URI']=="/join-our-team.php"){ ?>
<title>Caricaturetoons.Com - Make A Caricature Online</title>

<meta name="description" content="At Caricature Toons we are fast becoming one of the largest and most trusted online caricature ordering sites on the web. A big part of what makes us successful is that we offer many different styles of caricatures online." />

<meta name="keywords" content="make a caricature online, Caricature Toons" />
<?php }else{ ?>
<title><? if($seo_data[$page_name]['title']!='') { if($fname){ echo $fname."'s - "; } echo $seo_data[$page_name]['title']; }?><? if($metares['ti_pg_title']) { echo $metares['ti_pg_title']; }?></title>
<meta name="description" content="<? if($seo_data[$page_name]['description']!='') { if($fname){ echo $fname."'s - "; } echo $seo_data[$page_name]['description']; }?><? if($metares['ti_pg_des']) { echo $metares['ti_pg_des']; }?>">
<meta name="keywords" content="<? if($seo_data[$page_name]['keywords']!='') { echo $seo_data[$page_name]['keywords']; }?><? if($metares['ti_pg_keyword']) { echo $metares['ti_pg_keyword']; }?>">
<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="google-site-verification" content="paCo38l-ID2nUySU57XdeJaYEkkIur3KMvF4ZgM5bnc" />
<meta name="msvalidate.01" content="D15203FFA7C20880B7F06B9C1164017B" />

<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10461811-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();



function headvalidateemail()
{
	if(document.getElementById('email_news').value=='')
	{
		alert('Please enter email');
		return false;
	}
	else
	{
		return true;
	}
}
function headcheckemail(myForm)
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.email_news.value))
	{
		return true;
	}
	else
	{
		alert('Please enter valid email');
		return false;
	}
}

function textclear(id)
{
	document.getElementById(id).value="";
}

function showtext(id)
{
	document.getElementById(id).value = 'Enter email address';
	document.getElementById(id).style.color='#000';
}
</script>
</head>
<body>
	<div id="outer_wrap">
		<!--header starts-->
		<div id="header">
			<div class="header_bg_color">
				<div style="margin: 0px 0px 0px 410px; width: 540px; float: left;position:absolute;">
					<div style="margin:5px 0 0 0px;float:left;"><img src="<?=$_SERVER['HTTP_HOST']?>images/win_free.png" border="0" alt="infree" title="winfree"/></div>
                    <div style="position:relative;" class="div_text_green"><?=$msg?></div>
					 <form action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return headcheckemail(this)" style="margin:0px;">
					<div style="background: none repeat scroll 0% 0% transparent; border: medium none; width: 134px; height: 15px; margin: 0pt; font-family: Verdana,Arial,Helvetica,sans-serif; font-size: 11px; float: left; <? if($msg) { ?> padding: 3px 13px 13px 13px; <? } else { ?> padding:13px; <? } ?>"><input type="text" name="email_news" value="enter email address" id="email_news" autocomplete="off" style="border-radius:25px; -moz-border-radius: 25px; -webkit-border-radius: 25px; color:#666; width:155px;" onclick="textclear('email_news');" /></div>
					
					<div style="float: left; <? if($msg) { ?>padding: 1px 57px 10px 20px;<? } else { ?>padding: 10px 57px 10px 20px; <? } ?>"><input type="image" name="join" onclick="return headvalidateemail()" src="<?=$_SERVER['HTTP_HOST']?>images/join_button.png" border="0" alt="join" title="join" /></div>
					</form> 				
					<div style=" <? if($msg) { ?>padding:0 0 8px 0;<? } else { ?>padding:8px 0; <? } ?>" > 
						<a href="<?=$_CONFIG['facebook_username']?>"> <img src="<?=$_SERVER['HTTP_HOST']?>images/facebook.png" width="30px" border="0px"/></a>&nbsp;
						<a href="<?=$_CONFIG['twitter_username']?>" > <img src="<?=$_SERVER['HTTP_HOST']?>images/twitter.png" width="30px" border="0px" /></a>&nbsp;
						<a href="<?=$_CONFIG['youtube_username']?>" > <img src="<?=$_SERVER['HTTP_HOST']?>images/youtube.png" width="30px" border="0px"/></a>&nbsp;
						<a href="<?=$_CONFIG['blog_username']?>" > <img src="<?=$_SERVER['HTTP_HOST']?>images/Blogger.png" width="30px" border="0px"/></a>&nbsp;
					</div>
				</div>
				<div  class="logo"><a href="<?=$_SERVER['HTTP_HOST']?>index.php"><img src="<?=$_SERVER['HTTP_HOST']?>images/logo.png" border="0" alt="caricaturetoons" title="Caricaturetoons"/></a></div>
				<div class="header_menu">
					<img src="<?=$_SERVER['HTTP_HOST']?>images/header_menu.gif" border="0" usemap="#Map"  height="152" width="600"/>
					<map name="Map" id="Map">
					  <area shape="poly" coords="145,73,143,56,51,72,-1,73,2,96,20,98,23,111,70,110,150,96,194,97,194,72" href="<?=$_SERVER['HTTP_HOST']?>"  />
					  <area shape="poly" coords="117,42" href="#" /><area shape="poly" coords="196,69,196,98,432,115,435,71,183,54,183,69" href="<?=$_SERVER['HTTP_HOST']?>triathlon-caricature-toons-ideas.php" />
					<area shape="poly" coords="447,102,452,62,586,75,582,96,576,115" href="<?=$_SERVER['HTTP_HOST']?>my-caricature-toons.php" />
					<area shape="poly" coords="1,114,0,148,181,147,178,113,171,97,113,111" href="<?=$_SERVER['HTTP_HOST']?>order-caricature.php" />
					<area shape="poly" coords="186,105,435,122,434,150,187,148,187,120" href="<?=$_SERVER['HTTP_HOST']?>buy-caricature-gift.php" />
					<area shape="poly" coords="455,112,577,122,575,153,450,149" href="<?=$_SERVER['HTTP_HOST']?>contact.php" />
					</map>
			  </div>
		  	</div>
			<div class="headershadow">&nbsp;</div>
			<? if(isloggedIn() ||($getuserDetails['utype_id']==2))
				{
				$getuserDetails = getUserDetails($_SESSION['sess_tt_uid']);//Fetching the user details according to the userid
				?>
					<div align="right" style="padding-right:10px;" class="header_text">
                    Hello <?=$getuserDetails['user_fname'];?> |
                    <a href="<?=$_SERVER['HTTP_HOST']?>aproset.php" class="header_links">Account</a> |
                    <a href="<?=$_SERVER['HTTP_HOST']?>logout.php" class="header_links">Sign out</a> | 					
                    <a href="<?=$_SERVER['HTTP_HOST']?>cusvidtut.php" class="header_links">Help</a> 
<!--                <a href="<?=$_SERVER['HTTP_HOST']?>contact.php" class="header_links">Contact</a>
-->                 </div><div style="height:15px;"></div>
				<? }
				else
				{
				?>
                <div align="right" style="padding-right:25px;padding-bottom:10px;" class="header_text"> 
					<a href="<?//=$_SERVER['HTTP_HOST']?>alogin.php" class="header_links">Login</a> |
                    <a href="<?//=$_SERVER['HTTP_HOST']?>alogin.php" class="header_links">Register</a>
                </div>
                <?
                }
				?>
		</div>