<?  include("includes/configuration.php");
	ini_set("memory_limit","2000M");
	include('includes/imageResize.php');
	include("includes/resizeimage.php");

	if(isset($_REQUEST['toon_gallery_name']) && $_REQUEST['toon_gallery_name']!="")
	{
		$toon_link=$_REQUEST['toon_gallery_name'];
		$page_qry="SELECT * FROM toons_ideas WHERE ti_ref_link='".$toon_link."'";
		$page_res=mysql_query($page_qry);	
		$data_count=mysql_num_rows($page_res);
		if($data_count>0){
			$page_row=mysql_fetch_array($page_res);
		}
		else
		{
			echo "<script>window.location='http://www.caricaturetoons.com/index.php';</script>";
			exit();	
		}
	}
	else
	{
		echo "<script>window.location='http://www.caricaturetoons.com/index.php';</script>";
		exit();	
	}
	
	$sql="SELECT COUNT(DISTINCT(toon_users.user_id)) AS cnt , MIN(toon_products.product_price) prd_min FROM  toon_users INNER JOIN toon_products ON toon_products.user_id = toon_users.user_id  WHERE toon_users.utype_id=2 AND toon_users.user_status='Active' AND toon_products.product_delete=0";
	$res_ct=mysql_query($sql);
	$result_prd=mysql_fetch_array($res_ct);
	include (DIR_INCLUDES.'header.php');
?> 

 <link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-pack.js"></script>
<script type="text/javascript" src="js/jquery.imgareaselect-0.3.min.js"></script>
	
<link rel="stylesheet" type="text/css" href="<?=$_SERVER['HTTP_HOST']?>styles/highslide.css" />
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/highslide-full.js"></script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/imageswap.js"></script>
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />
<!--<base href="http://www.toonsforu.com/" />-->
<base href="http://www.caricaturetoons.com/" />
<!--<base href="http://localhost/priswin/caricaturetoons/" />-->
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.captionText ="<a onclick='hs.close();'><img src='images/close.gif' /></a>",
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;

	// define the restraining box
	hs.useBox = true;
	hs.width = 280;
	hs.height = 400;

	// Add the controlbar
	hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: false,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: 1,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
		<!--header ends-->
		<!--content starts-->
		<div id="content">
        	<? if($getuserDetails['utype_id']!=2) { ?>
			<div style="height:80px;">
                <?php /*?><div style="margin:0 0 0 40px;float:left;"><a href="http://referzo.com/seal.php?merchant_id=249&refer_url=www.caricaturetoons.com" style="text-decoration:none;" target="_blank"><img src="<?=$_SERVER['HTTP_HOST']?>images/earn_referred.png" border="0"/></a></div><?php */?>
                <div style="margin:0 0 0 175px;float:left;">&nbsp;</div>
                <div style="padding:0 0 0 140px;float:left;"><img src="<?=$_SERVER['HTTP_HOST']?>images/source_caricatures.png" border="0"/></div>
                <div style="padding:0 0 0 780px;">
				<script type="text/javascript" src="http://cdn.socialtwist.com/2011113055505/script.js"></script><a class="st-taf" href="http://tellafriend.socialtwist.com:80" onclick="return false;" style="border:0;padding:0;margin:0;"><img alt="SocialTwist Tell-a-Friend" style="border:0;padding:0;margin:0;" src="http://images.socialtwist.com/2011113055505/button.png" onmouseout="STTAFFUNC.hideHoverMap(this)" onmouseover="STTAFFUNC.showHoverMap(this, '2011113055505', window.location, document.title)" onclick="STTAFFUNC.cw(this, {id:'2011113055505', link: window.location, title: document.title });"/></a>
                </div>
            </div>
                
            <div style="height:150px;">
                <div style="float: left; width: 190px; padding: 0pt 0pt 0pt 15px;position:absolute;z-index:1000;"><a href="terms.php"><img src="<?=$_SERVER['HTTP_HOST']?>images/guarantee-seal.png" width="190px" border="0" /></a></div>
                <div style="padding: 30px 10px 0px 220px;position:absolute;" >
                     <div class="header_text" style="vertical-align:text-bottom; width:550px;"><?=$page_row['ti_top_text'];?></div>					
                    
                </div>
                <div style="float:right;margin:-50px 15px 0px 0px; position: relative;" >
                    	<div style="position: absolute; float: right; color: rgb(255, 255, 0); text-align: center; width: 173px; margin-top: 50px;" class="toon_digit_top"><?=$result_prd['cnt'];?></div>
                        <div style="position: absolute; float: right; color: rgb(255, 255, 0); text-align: center; width: 173px; margin-top: 167px; letter-spacing: 0pc;" class="toon_digit_bottom">$<?=$result_prd['prd_min'];?></div><img src="<?=$_SERVER['HTTP_HOST']?>images/Homepageadd.gif" width="187" height="288" /></div>
            </div>     
            <div style="height:75px;"></div>
            <? } ?>
            <div style="height:25px;"></div>
			<div>			
				<div class="artistprice_white_curve_middle_border" style="margin-right: 20px; margin-bottom: 20px; border-radius: 15px 15px 15px 15px; margin-left: 23px; width: 935px;">
					
					
					<div  style="-moz-border-radius:35px;">
					
					<div style="height:30px;"></div>
						<div style="height:40px;clear:left;text-align:center;" class="text_blue line_space">
							<div align="center"><img alt="<?=$page_row['ti_ref_name']?>" title="<?=$page_row['ti_ref_name']?>" src="<?=$_SERVER['HTTP_HOST']?>show_text/<? echo base64_encode(strtoupper($page_row['ti_ref_name']));?>/17/" border="0" /></div>
                        </div>
						<?
						$image_description=mysql_query("SELECT * FROM toon_admin_artist_images INNER JOIN toon_users ON toon_admin_artist_images.artist_id=toon_users.user_id WHERE toon_admin_artist_images.ti_id=".$page_row['ti_id']);
							$img_num = mysql_num_rows($image_description);
							$height=ceil($img_num/4)*350+10;
						?>
                        <div style="text-align: center; padding-bottom: 30px; padding-left: 10px; width: 920px; height:<?=$height?>px;">
                       
						<?php
							if($img_num > 0)
							{
								while($image_result=mysql_fetch_array($image_description))
								{?>	
									<div style="padding-left:20px; padding-top:30px; float:left;">
									<img src="<?=$_SERVER['HTTP_HOST']?>z_uploads/admin_artist_gallery/thumb_artist_images/th_<?=$image_result['img_name']?>"/><br/>
                                    <a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/admin_artist_gallery/artist_images/<? echo $image_result['img_name']; ?>" onclick="return hs.expand(this)" ><img src="<?=$_SERVER['HTTP_HOST']?>images/enlarge.png" border="0" alt="enlarge" title="Enlarge" width="80" style="padding-top: 10px; padding-bottom: 5px;" /></a><br/>
                                    <a href="art-gall.php?art_id=<?=$image_result['user_id']?>" style="font-family:Arial; text-decoration:none;font-size:18px; font-weight:bold; color:#0033CC;"><?php echo strtoupper($image_result['user_fname']);?></a><br/>
                                    <div style="float:right;"><a href="art-gall.php?art_id=<?=$image_result['user_id']?>" style="font-family:Arial;text-decoration:none;font-size:12px; font-weight:bold; color:#0033CC;">More ></a></div>
                                    </div>
								<?php
								}
							}
					?>
					</div>	
				</div>
				
			</div>
			 <div class="header_text" style="padding-left: 25px; padding-right: 25px;"><?=$page_row['ti_bottom_text'];?></div>
            <div style="height:50px;"></div>
		</div>
		
		<!--content ends-->	
		<!--footer-->	

<? if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_footer.php');
}
else
{
include (DIR_INCLUDES.'footer.php') ;
} ?>


<script>

function savetext(id,row,type,s_id)
{

var text;
text=document.getElementById(id).value;
var p_id=row;
var t_type=type;
var sav=s_id;
if (window.XMLHttpRequest)
  {
  
  xmlhttp=new XMLHttpRequest();
  
  }
else
  {
  
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(s_id).innerHTML=xmlhttp.responseText;
	setTimeout('document.getElementById("'+s_id+'").style.display="block"',1)
	setTimeout('document.getElementById("'+s_id+'").style.display="none"',2000)
	
    }
  }
document.getElementById(s_id).innerHTML='saving...';  
xmlhttp.open("GET","savetext_ajax.php?text="+text+"&id="+p_id+"&type="+t_type,true);
xmlhttp.send();



}




</script>