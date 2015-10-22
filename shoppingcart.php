<? 
	include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	$u_id=$_SESSION['sess_tt_uid'];
	if(!isloggedIn())
	{
		header('Location:alogin.php');
		exit();
	}
	$cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id AND `cart_status`='active'");
	$cartarray_row=mysql_fetch_assoc($cartarray_rs);
	$number_row=mysql_num_rows($cartarray_rs);
	if($number_row==0)
	{
	header("Location:buy-caricature-gift.php");
	exit();
	}
	$cart=unserialize(base64_decode($cartarray_row['cart_array']));
	if($_REQUEST['cart']=='empty')
	{
		unset($cart);
		mysql_query("DELETE FROM `toon_cart` WHERE `user_id`=$u_id  AND `cart_status`='active'");
		header("Location:buy-caricature-gift.php");
		exit();
	}
	elseif($_POST['rem_project_id']!='')
	{
		$projectid=$_POST['rem_project_id'];
		unset($cart[$projectid]);
		$cart=array_filter($cart);
		if(empty($cart))
		{
			unset($cart);
			mysql_query("DELETE FROM `toon_cart` WHERE `user_id`=$u_id  AND `cart_status`='active'");
			header("Location:buy-caricature-gift.php");
		}
		else
		{
			$serialised=base64_encode(serialize($cart));
			mysql_query("UPDATE `toon_cart` SET `cart_array` =  '$serialised',`cart_modified` = now() WHERE `user_id` ='$u_id'  AND `cart_status`='active'");
			header("Location:shoppingcart.php");
		}
		exit();
	}
	$spo_ez_query = mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='ez product'");
	$number_spo_ez = mysql_num_rows($spo_ez_query);
	$spo_ez_row = mysql_fetch_assoc($spo_ez_query);

	include (DIR_INCLUDES.'header.php');
?> 
<script>
function changecart(projectid, type)
{
			if(projectid)
			{
				var number=document.getElementById('cartnumber_'+projectid).value;
				if(number>0 && number!="")
				{
					document.getElementById('num_'+projectid).innerHTML=number;
				}
			}
			else
			{
			var number=0;
			var projectid=0;
			var todisable='yes';
			}
	if( (number==0 || number=="") && type == 0)
			{
				alert("please enter valid quantity");
				return false;
			}
			var pcode=document.getElementById('pcode').value;
			var xmlhttp;
							
				xmlhttp=GetXmlHttpObject();
				if (xmlhttp==null)
					{
						alert ("Your browser does not support XMLHTTP!");
						return;
					}
				var url="ajax_cartchange.php";
				url=url+"?number="+number;
				url=url+"&projectid="+projectid;
				url=url+"&pcode="+pcode;
				url=url+"&sid="+Math.random();	
				xmlhttp.onreadystatechange=stateChanged2;
				xmlhttp.open("GET",url,true);
				xmlhttp.send(null);
			function stateChanged2()
			{
				if (xmlhttp.readyState==4)
					{
						if(xmlhttp.responseText)
							{
								var price_array=xmlhttp.responseText.split('||');
								
								document.getElementById('totalprice1').innerHTML = parseFloat(price_array[0]).toFixed(2);
								document.getElementById('totalprice2').innerHTML = parseFloat(price_array[0]).toFixed(2);
								if(price_array[1]=="")
								{
								document.getElementById('discount_price').innerHTML = '0.00';
								}
								else
								{
								document.getElementById('discount_price').innerHTML = parseFloat(price_array[1]).toFixed(2);
								}
								document.getElementById('total_price').innerHTML = parseFloat(price_array[0]-price_array[1]).toFixed(2);
								//if(document.getElementById('totalstored').value!=xmlhttp.responseText && todisable=='yes')
//								{
//								document.getElementById('pcode').disabled=true;
//								}
								document.getElementById('totalstored').value = xmlhttp.responseText;
								
							}
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
function remove_fromcart(cart_item)
{
	if(cart_item!="")
	{
		if(confirm("Are you sure you want to remove this item from cart?"))
		{
			document.getElementById('rem_project_id').value=cart_item;
			document.rem_from_cart.submit();
		}
	}
}
</script>
<link href="styles/style.css" rel="stylesheet" type="text/css" />

	<div id="content">
		<div style="height:80px;"></div>
			<table cellpadding="0" cellspacing="0" border="0" width="100%"  align="center">
				<tr>
					<td valign="top" width="72%"><table cellpadding="0" cellspacing="0" width="100%" align="right">
			<tr>
				<td height="12" valign="bottom" align="right"><img src="images/top_left_curve.png" /></td>
				<td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
				<td width="17"><img src="images/top_right_curve.png" /></td>
			</tr>
			<tr>
				<td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
				<td valign="top" bgcolor="#FFFFFF">
				<table cellpadding="0" cellspacing="0" border="0" width="96%" align="center" >
				<tr><td colspan="2" height="15"><form name="rem_from_cart"  method="post" ><input type="hidden" name="rem_project_id" id="rem_project_id" value="" />
                </form></td></tr>
				<tr bgcolor="#FF6E01">
				<td width="27%"  height="40" valign="middle" align="center"><img src="images/shopping.gif" border="0" alt="shopping cart" title="Shopping cart" /></td>
				<td width="73%"><img src="images/cartimg.gif" border="0" alt="shopping cart" title="Shopping cart" /></td>
				</tr>
				<tr>
				<td valign="middle" height="40" colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;color:#000000;font-weight:bold;">Photo Gifts</td>
				</tr>
				<tr>
				<td valign="top" colspan="2">
					<table cellpadding="0" cellspacing="0" border="0" width="100%" >
                    <? 
					foreach ($cart as $key=>$name)
					{
					//$total+=$name['number']*$name['ezproduct_price'];
					 ?>
						<tr bgcolor="#B0E8F7" >
						<td height="20" ><img src="images/photo.gif" border="0" alt="photo" title="Photo" /></td>
						<td width="212" ><img src="images/quantity.gif" border="0" alt="quantity" title="Quantity" /></td>
						<td width="286" ><img src="images/description.gif" border="0" alt="description" title="Description" /></td>
						<td width="105"><img src="images/unitprice.gif" border="0" alt="unit price" title="Unit price"/></td>
                        <td class="normal_font" ></td>
						</tr>
						<tr >
						<td width="138" ><img width="100" src="<?=$name['thumbUrl']?>" border="0" /></td>
						<td>					
						      <input type="text"  class="textField_cartprice" value="<?=$name['number']?>"  onchange="changecart('<?=$key?>',0)"   name="cartnumber" id="cartnumber_<?=$key?>" />						  </td>
						<td class="normal_font" ><?=$name['ezproduct_name'];?></td>
						<td class="normal_font" >$<?=number_format($name['ezproduct_price'], 2);?></td>
                        <td class="normal_font" ><a href="#" onclick="remove_fromcart('<?=$key?>');return false;" ><img src="images/delete.png" border="0" alt="Del" title="remove item"/></a></td>
						</tr>
						<tr><td colspan="5" height="25"></td></tr>	
                        <? } ?>				
				<tr>
					<td valign="top" colspan="5" >
						<table cellpadding="0" cellspacing="5" border="0" width="100%"  >
                        <?
						$pricedetails=ezprice_details();
						?>					
					<tr>
					<td width="86%" align="right" class="normal_font">Order Total :</td>
					<td width="10%" align="right"class="normal_font">$<span id="totalprice1"><? echo number_format($pricedetails['totalprice']-$pricedetails['discount'],2);?></span></td>
					<td width="4%"></td>
					</tr>
					</table>					</td>
					</tr>
					<tr>
					<td valign="top" colspan="5">
						<table cellpadding="0" cellspacing="0" border="0" width="57%" align="right" >					
					<tr>
					<td width="30%"><a href="shoppingcart.php?cart=empty"><img style="cursor:pointer" src="images/emtycatr.gif" border="0" alt="empty cart" title="Empty cart" /></a></td>
					<td width="41%"><a href="buy-caricature-gift.php"><img style="cursor:pointer" src="images/continueshopping.gif" border="0" alt="continue shopping" title="Continue shopping" /></a></td>
					<td width="29%" align="right"><a href="merckout.php"><img style="cursor:pointer" src="images/checkout_button.gif" border="0" alt="checkout" title="Checkout" /></a></td>
					</tr>
					</table>					</td>
					</tr>
					</table>				</td>
				</tr>
				<tr>
				<td valign="top" colspan="2" height="35"></td>
				</tr>
				</table>
				</td>
				<td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
			</tr>
			<tr>
				<td align="right"><img src="images/btm_left_curve.png" /></td>
				<td style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
				<td><img src="images/btm_right_curve.png" /></td>
			</tr>
		</table></td>
					<td valign="top" width="28%"><div><table cellpadding="0" cellspacing="0" width="100%" >
			<tr>
				<td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
				<td width="413" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
				<td width="26"><img src="images/top_right_curve.png" /></td>
			</tr>
			<tr>
				<td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
				<td valign="top" bgcolor="#FFFFFF">
					<table cellpadding="0" cellspacing="0" border="0" width="95%"  align="center">
					<tr><td width="27%"  height="15" colspan="2"></td>
					</tr>
				<tr bgcolor="#FF6E01">
				<td   height="40" align="center" colspan="3" valign="middle"><img src="images/order_summery.gif" border="0" alt="order summary" title="Order summary" /></td>				
				</tr>
				<tr><td colspan="3" height="10"></td></tr>
				<tr><td valign="top"><table cellpadding="0" cellspacing="5" border="0" width="92%"  align="center"><tr>
				<td width="76" height="16" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><b>QTY</b></td>
				<td width="149" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><b>Item</b></td>
				<td width="62" align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><b>Price</b></td>
				</tr>
                <? foreach ($cart as $key=>$name)
					{
					//$total_side+=$name['number']*$name['ezproduct_price'];
					 ?>
				<tr>
				<td valign="top" class="normal_font" id="num_<?=$key?>"><?=$name['number']?></td>
				<td valign="top" class="normal_font" ><?=$name['ezproduct_name'];?></td>
				<td valign="top" align="right" class="normal_font" >$<?=number_format($name['ezproduct_price'],2);?></td>
				</tr>
                <? }?>
                <input type="hidden" id="totalstored" value="<?=$total_side?>"  />
                <tr><td>&nbsp;</td></tr>
				<tr><td colspan="3" valign="top">
					<table cellpadding="0" cellspacing="5" border="0" width="100%">
					<tr>
					<td width="70%" align="right" class="normal_font"><b>Sub Total :</b></td>
					<td width="30%" align="right" class="normal_font"><b>$<span id="totalprice2"><? echo number_format($pricedetails['totalprice'],2);?></span></b></td>
					</tr>
                    <tr>
					<td width="70%" align="right" class="normal_font"><b>Discount :</b></td>
					<td width="30%" align="right" class="normal_font"><b>$<span id="discount_price"><? echo number_format($pricedetails['discount'],2);?></span></b></td>
					</tr>
                    <tr>
					<td width="70%" align="right" class="normal_font"><b>Total :</b></td>
					<td width="30%" align="right" class="normal_font"><b>$<span id="total_price"><? echo number_format($pricedetails['totalprice']-$pricedetails['discount'],2);?></span></b></td>
					</tr>
					<tr><td colspan="2" height="5" align="right"><img src="images/dot_border.gif" /></td></tr>
					<tr><td colspan="2">
						<table  cellpadding="0" cellspacing="0" border="0" width="100%">
                    <? if($number_spo_ez==0){?>    
                    <tr><td width="56%" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px; font-weight:bold" align="right">Coupon code</td>
               		<td width="44%"  align="right"><input class="textField_cart" id="pcode" <?php /*?><? if($pricedetails['discount']!=0){echo 'disabled="disabled"';}?><?php */?>  name="pcode" value="<?=$cartarray_row['promo_code'];?>" type="text" /></td>
                	</tr>
					<tr><td colspan="2"  height="5"></td></tr>
					<tr><td colspan="2" align="right"><img style="cursor:pointer"  onclick="changecart(0,1)" src="images/applycode.gif" border="0" alt="apply code" title="Apply code" /></td></tr>
                    <? }else {?>
                    <input type="hidden" name="pcode" id="pcode" />
                    <tr><td colspan="2" style="color:#ff6e01;font-family:Arial, Helvetica, sans-serif;font-size:12px;"><?=$spo_ez_row['spo_title']?> : <?=$spo_ez_row['spo_description']?></td></tr>
                    <? }?>	
					<tr><td colspan="2"  height="5"></td></tr>					
					<tr><td colspan="2" align="right"><a href="merckout.php"><img style="cursor:pointer" src="images/checkout_button.gif" border="0" alt="checkout" title="Checkout"/></a></td></tr>
					<tr><td colspan="2"  height="15"><img src="images/paypal.gif" border="0" width="60" /></td></tr>
					</table>
					</td></tr>
					</table>
				</td></tr>
				</table></td></tr>
				</table>
					</td>
				<td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
			</tr>
			<tr>
				<td><img src="images/btm_left_curve.png" /></td>
				<td style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
				<td><img src="images/btm_right_curve.png" /></td>
			</tr>
		</table></div>
		</td>
				</tr>
			</table>
		
<? include (DIR_INCLUDES.'footer.php') ?>
