<?  include("includes/configuration.php");
	include("includes/functions/encryption.php");
	$shoform=true;
	@$encrypt_obj = new AzDGCrypt(1074);
	$user_id= $_SESSION['sess_tt_uid'];//Fetching the userid
	$getuserDetails = getUserDetails($user_id);//Fetching the user details according to the userid
	$res=mysql_query("SELECT * FROM `toon_users` where user_id='$user_id'");
	$row=mysql_fetch_array($res);
	$user = $_REQUEST['artist'];
	$product_id=$_REQUEST['product'];
	$change_proid = $_POST['change_proid1'];
	
	/*if($change_proid)
	{
		$pro_priority1=$_POST['pro'.$change_proid];
		$query1= "UPDATE `toon_products` SET `product_priority`='$pro_priority1' WHERE `product_id`='$change_proid' AND `product_delete`=0";
		$result1 = mysql_query($query1);
	}*/
	
	if($product_id)
	{
		$del_query="UPDATE `toon_products` SET `product_delete` = '1'  where product_id='$product_id'";
		mysql_query($del_query);
	}
	$artist_name=mysql_fetch_assoc(mysql_query("SELECT `user_fname` FROM `toon_users` WHERE `user_id`='$user'"));

	$sql_product="SELECT * FROM `toon_products` WHERE `user_id`='$user' AND `product_delete`=0";
	$rs_product = mysql_query($sql_product);	
	$count=mysql_query( "SELECT COUNT( * ) as count FROM  `toon_products` WHERE  `user_id` ='$user' AND `product_delete`=0 GROUP BY `user_id`  ORDER BY `product_priority` ASC");
 	$artistpdt_count=mysql_fetch_assoc($count);
	if($getuserDetails['utype_id']==2)
	{
		include (DIR_INCLUDES.'artist_header.php');
	}
	else
	{
		include (DIR_INCLUDES.'header.php');
	}
		
?> 
<script type="text/javascript">
function show_confirm()
{
	var r=confirm("Do you really want to delete this product?");
	return r;
}
function changepriority1(proid)
{
	document.getElementById("change_proid1").value=proid;
	document.listartistproducts.submit();
}
</script>
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css"/>
<script type="text/javascript">
    hs.graphicsDir = '../images/graphics/';
    hs.outlineType = 'rounded-white';
    hs.wrapperClassName = 'draggable-header';
</script>

<SCRIPT TYPE="text/javascript">
<!--
function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=300,height=135,scrollbars=yes');
return false;
}
//-->
</SCRIPT>	
	<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		
		<div id="content">
        
			<div class="height80"></div>
			<div style="height:20px;"></div>									
			<div>
				<div class="buy_now_curvepadding" style="margin-left:160px;background-repeat:no-repeat"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip profile_sttings_whiteCurve_middle_strip" style="width:650px;"></div>
				<div><img src="images/white_curve_top_right.gif" /></div>				
				<div class="price_white_curve_middle_border profile_sttings_middle_content" style="clear:both;width:690px;">	
				<td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_product);
		if ($number!=0)
		{
		?>
		<form action="" method="post" name="listartistproducts">
        	<?php /*?><table width="100%" cellpadding="5" cellspacing="0">
        	 	<tr>
                  <td colspan="8" align="right"><input type="button" value="Add Products" onclick="window.location='artist_add_products.php?artist=<?=$user;?>'"/></td>
                </tr>
            </table><?php */?>    
            <table cellpadding="4" cellspacing="0" width="100%" class="table_border" >
              <tr class="table_titlebar">
                <td class="main_heading">Product Title</td>
                <td class="main_heading">Description</td>
                <td class="main_heading">Turnaround Time</td>
                <td class="main_heading">Product price</td>
                <td class="main_heading">Wholesale price</td>
                <td class="main_heading">Additional Person price</td>
				<!--<td class="main_heading">Product Priority</td>-->
				<td class="main_heading">Actions</td>
              </tr>
			  
			   <input type="hidden" id="change_proid1" name="change_proid1" />
              <?
	   while($row_product=mysql_fetch_assoc($rs_product))
	   {
	     $pdt_desc=$row_product['product_description'];
	     $pdt=substr($pdt_desc,0,20);
	   ?>
              <tr>
                <td align="left" class="text_blue"><?=$row_product['product_title']?></td>
                <td align="left" class="text_blue"  ><div><a href="artist_product_description.php?product=<?=$row_product['product_id'];?>&artist=<?=$user;?>" onClick="return popup(this, 'notes')" style="text-decoration:none;" class="text_blue"><?=$pdt?></a></div></td>
                <td align="left" class="text_blue"><?=$row_product['product_turnaroundtime']?> days</td>
                <td align="left" class="text_blue"><?=$row_product['product_price']?></td>
                <td align="left" class="text_blue"><?=$row_product['product_wholesale_price']?></td>
                <td align="left" class="text_blue"><?=$row_product['product_additionalCopy_price']?></td>				
				<?php /*?><td align="left" class="text_blue"><select name="pro<?=$row_product['product_id']?>" onchange="return changepriority1(<?=$row_product['product_id']?>)">
                  <? for($i=1;$i<=$artistpdt_count['count'];$i++)
					{ ?>
                  <option value="<?=$i?>" <? if($row_product['product_priority']==$i) {?> selected="selected"<? } ?>>
                    <?=$i?>
                    </option>
                  <? } ?>
                </select></td><?php */?>
				<td align="left" class="text_blue"><a href="artist_add_products.php?product=<?=$row_product['product_id'];?>&artist=<?=$user;?>"><img border="0" src="images/edit.png" title="Modify the Product" alt="Modify the Product" /></a>
                <a onclick="return show_confirm()" href="listout_artist_products.php?product=<?=$row_product['product_id'];?>&artist=<?=$user;?>"><img border="0" src="images/delete.png" title="Delete this Product" alt="Delete this Product"/></a>
                </td>
			  </tr>
              <?
	   }
       ?>
            </table>
			</form>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Products!</td>
              </tr>
            </table>
            <? } ?>
          </td>
					<div class="clear_both" style="height:3px;"></div>
				</div></div>
				
				<div>
					<div class="buy_now_curvepadding profile_sttings_btm_curve"><img src="images/contact_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip profile_sttings_whiteCurve_middle_strip" style="width:650px;"></div>
					<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
			
			<div class="profile_btm_height">&nbsp;</div>
        
		</div>
		
		
		<!--content ends-->	
		<!--footer-->	
<? 
 if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_footer.php');
}
else
{
include (DIR_INCLUDES.'footer.php') ;
} ?>
