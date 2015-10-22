<?
 include("includes/configuration.php");
 include (DIR_INCLUDES.'functions/encryption.php');
 @$encrypt_obj = new AzDGCrypt(1074);
 if(!isloggedIn())
 {
	header('Location:alogin.php?back_to=ezbuilder.php?opro_id='.$_REQUEST['opro_id']);
	exit();
 }
 $opro_id=$_REQUEST['opro_id'];
 if(!$opro_id)
 {
	header('Location:my-caricature-toons.php');
	exit();
 }
 $u_id=$_SESSION['sess_tt_uid'];
 $enc_u_id=$encrypt_obj->crypt($u_id);
 
 include (DIR_INCLUDES.'header.php');
 
 $ezproductdetails=mysql_query("SELECT * FROM `toon_ez_products` WHERE `ezproduct_id`='$opro_id'");
 $ezproductdetails_row=mysql_fetch_array($ezproductdetails);
 $sku=$ezproductdetails_row['ezproduct_sku'];
 $ecat_id=$ezproductdetails_row['ecat_id'];
 
 $catname_details=mysql_fetch_array(mysql_query("SELECT * FROM `toon_ez_categories` WHERE `ecat_id`='$ecat_id'"));
 $cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id AND `cart_status`='active'");
 $cartarray_row=mysql_fetch_assoc($cartarray_rs);
 $number_row=mysql_num_rows($cartarray_rs);
 
 if($number_row)
 {
	$cart_pdt_num=count(unserialize(base64_decode($cartarray_row['cart_array'])));
 }
 else
 {
	$cart_pdt_num=0;
 }
 
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Your Page Title Here</title>
</head>
<script src="javascripts/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="javascripts/menu-collapsed.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="styles/menu_style.css" />
<script type="text/javascript" src="http://apps.ezprints.com/home/10073FE3-AD4C-479D-A9FD-B68D4AFDAC41.ezp"> </script>
<script type="text/javascript">
// fires when the application is ready for use
var ez_sku = '<?=$sku?>';
function builder(ezsku)
{
	application.setSku(ezsku);
	ez_sku = ezsku;
}
var readyHandler = function()
{
}
var addToCartComplete = function (projectId, productSku, thumbUrl)
{
	var opro_id=<?=$opro_id?>;
	var xmlhttp
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
			{
				alert ("Your browser does not support XMLHTTP!");
				return;
			}
		var url="ajax_ezoprodetails.php";
		url=url+"?ez_sku="+ez_sku;
		url +="&projectId="+projectId;
		url +="&thumbUrl="+thumbUrl;
		url=url+"&sid="+Math.random();	
		xmlhttp.onreadystatechange=stateChanged2;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	function stateChanged2()
	{
		if (xmlhttp.readyState==4)
			{
				window.location='shoppingcart.php'
			}
	}
	function GetXmlHttpObject()
		{
			if (window.XMLHttpRequest)
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					return new XMLHttpRequest();
				}
			if (window.ActiveXObject)
				{
					// code for IE6, IE5
					return new ActiveXObject("Microsoft.XMLHTTP");
				}
			return null;
		}
}

/*
	mediaPickerSources: [	{ id: "1"
							  ,title: "Get photos from My Computer"
							  ,iconUri: "http://www.caricaturetoons.com/images/ez_logo.jpg"
							  ,collectionsUri: "http://www.caricaturetoons.com/source.php"
							  ,uploadUri: "http://www.caricaturetoons.com/otherphotos.php?u_id=<?//=$enc_u_id?>"
							}
						   ,{ id: "2"
							  ,title: "Get Photos from Caricaturetoons Albums"
							  ,iconUri: "http://www.caricaturetoons.com/images/ez_logo.jpg"
							  ,collectionsUri: "http://www.caricaturetoons.com/source.php"
							  ,uploadUri: null
							}
						]
*/
var application=ezp.apps.createTemplateApp(
{
	elementId: 'appDiv',
	sku:'<?=$sku?>',
	width:  810,
	height: 520,
	readyCallback: readyHandler,
	addToCartCallback: addToCartComplete,
	mediaPickerSources: 
         ["EZP Services", {id: "1", 
         title: "My Caricatures", 
         /*iconUri: "<?=$_CONFIG['site_url']?>images/ez_logo.jpg", */
         collectionsUri: "<?=$_CONFIG['site_url']?>source.php"}]
	,comboTrayInitialAssetCollectionUri: "<?=$_CONFIG['site_url']?>other_images.php"
});

function pdt_mouseover()
{
	document.getElementById("image_pdt").src='images/products_hover.gif'
}
function pdt_mouseout()
{
	document.getElementById("image_pdt").src='images/producits.gif'
}
</script>
<body>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<div id="content">
	<div style="height:5px"></div>
    <div>
		   
                <table cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
                            <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-bottom: 5px;" align="left" height="31" valign="top"><a href="buy-caricature-gift.php"><img src="images/view_more_products.gif" alt="view more products" border="0"/></a>&nbsp;</td><td width="345" style="background:url(images/shadow_top.png) repeat-x bottom;">&nbsp;</td>
                            <? if(isloggedIn()){?>
                             <td width="20" valign="top" align="right" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px"><a href="shoppingcart.php" class="header_links_ez"><img border="0" src="images/shop_img.png" /></a></td>
                             <td valign="top" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px">&nbsp;&nbsp;<a href="shoppingcart.php" class="header_links_ez"><?=$cart_pdt_num?> <? if($cart_pdt_num==1) {?> Item In Cart<? }else{?> Items In Cart<? }?></a></td>
                             <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px">&nbsp;</td>
                             <td valign="top" align="left" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px"><? if($cart_pdt_num!=0) {?><a href="shoppingcart.php" class="header_links_ez">View Cart</a><? }?></td>
                             <? }?>
                             <td valign="bottom"><img src="images/top_right_curve.png" /></td>
                        </tr>
                        <tr>
                            <td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
                            <td bgcolor="#FFFFFF" style="padding:10px;" colspan="6" align="center">
                                <table cellpadding="0" cellspacing="0">
                                    <tr bgcolor="#ff6e01">
                                        <td height="40" align="left"><span style="color:#FFFFFF;padding-left:10px;font-family:Arial, Helvetica, sans-serif;font-size:20px;"><b>Gift Ideas </b> <a href="merchandise_learn.php?cat_id=<?=$catname_details['ecat_id'];?>" style="color:#FFFFFF;text-decoration:none"><?=$catname_details['ecat_name'];?></a></b></span></td>
                                        <? 
                                                $rs_ezproducts=mysql_query("SELECT * FROM `toon_ez_products` WHERE `ecat_id`='$ecat_id' AND `ezproduct_display`='1' ORDER BY `ezproduct_priority` ASC");
                                        ?>
                                        <td align="right" >Change product size:
										
                                           <select  onChange="builder(this.value)"><? while($row_ezproducts=mysql_fetch_array($rs_ezproducts)) {?>
										  
										   <option style="font-family:Arial, Helvetica, sans-serif;" value="<?=$row_ezproducts['ezproduct_sku'];?>"  <? if($row_ezproducts['ezproduct_id'] == $opro_id) echo ' selected="selected"';?> ><?=$row_ezproducts['ezproduct_name'].' - $'.number_format($row_ezproducts['ezproduct_price'],2);?></option>
                                                 <? }?>
												
                                            </select>
                                        &nbsp;&nbsp;</td>
                                    </tr>
                                               
                                    <tr>
                                        <td colspan="2">           
                                            <div id="appDiv">
                                            <a href="http://www.adobe.com/go/getflashplayer">
                                            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                                            alt="Get Adobe Flash player" title="Get Adobe Flash player" />
                                            </a>
                                            </div>
                                      </td>
                                    </tr>
                            </table>
                            
                         </td>
                            <td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
                        </tr>
                        <tr>
                            <td><img src="images/btm_left_curve.png" /></td>
                            <td colspan="6" style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
                            <td><img src="images/btm_right_curve.png" /></td>
                        </tr>
                    </table>
			        
     </div>
	<div style="height:100px;">&nbsp;</div>
</div>

</body>
</html>
<? include (DIR_INCLUDES.'footer.php') ?>