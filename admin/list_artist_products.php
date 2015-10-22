<?
	include('includes/configuration.php');
	$user = $_REQUEST['artist'];
	$product_id=$_REQUEST['product'];
	$change_proid = $_POST['change_proid1'];
	
	if($change_proid)
	{
		$pro_priority1=$_POST['pro'.$change_proid];
		$query1= "UPDATE `toon_products` SET `product_priority`='$pro_priority1' WHERE `product_id`='$change_proid' AND `product_delete`=0";
		$result1 = mysql_query($query1);
	}
	
	if($product_id)
	{
		$del_query="UPDATE `toon_products` SET `product_delete` = '1'  where product_id='$product_id'";
		mysql_query($del_query);
	}
	$artist_name=mysql_fetch_assoc(mysql_query("SELECT `user_fname` FROM `toon_users` WHERE `user_id`='$user'"));

	$sql_product="SELECT * FROM `toon_products` WHERE `user_id`='$user' AND `product_delete`=0";
	$rs_product = mysql_query($sql_product);
	
	$count=mysql_query( "SELECT COUNT( * ) as count FROM  `toon_products` WHERE  `user_id` =$user AND `product_delete`=0 GROUP BY `user_id`  ORDER BY `product_priority` ASC");
 $artistpdt_count=mysql_fetch_assoc($count);
	
include ('includes/header.php');
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
	document.artistproducts.submit();
}
</script>
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css"/>
<script type="text/javascript">
    hs.graphicsDir = '../images/graphics/';
    hs.outlineType = 'rounded-white';
    hs.wrapperClassName = 'draggable-header';
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" colspan="4"><?=$artist_name['user_fname']?>'s Products</td>
        </tr>
        <tr>
          <td height="40px;" colspan="2"align="right"><input type="button" value="Add Products" onclick="window.location='add_artist_products.php?artist=<?=$user;?>'"/></td>
        </tr>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_product);
		if ($number!=0)
		{
		?>
		<form action="" method="post" name="artistproducts">
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading">Product Title</td>
                <td class="sub_heading">Description</td>
                <td class="sub_heading">Turnaround Time</td>
                <td class="sub_heading">Product price</td>
                <td class="sub_heading">Wholesale price</td>
                <td class="sub_heading">Additional Person price</td>
				<td class="sub_heading">Product Priority</td>
				<td class="sub_heading">Actions</td>
              </tr>
			   <input type="hidden" id="change_proid1" name="change_proid1" />
              <?
	   while($row_product=mysql_fetch_assoc($rs_product))
	   {
	     $pdt_desc=$row_product['product_description'];
	     $pdt=substr($pdt_desc,0,20);
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_product['product_title']?></td>
                <td align="left" class="table_details"><div><a href="product_descr.php?product=<?=$row_product['product_id'];?>&artist=<?=$user;?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax' } )"><?=$pdt?></a></div></td>
                <td align="left" class="table_details"><?=$row_product['product_turnaroundtime']?></td>
                <td align="left" class="table_details"><?=$row_product['product_price']?></td>
                <td align="left" class="table_details"><?=$row_product['product_wholesale_price']?></td>
                <td align="left" class="table_details"><?=$row_product['product_additionalCopy_price']?></td>
				
				
				
				<td align="left" class="table_details"><select name="pro<?=$row_product['product_id']?>" onchange="return changepriority1(<?=$row_product['product_id']?>)">
                  <? for($i=1;$i<=$artistpdt_count['count'];$i++)
					{
				    ?>
                  <option value="<?=$i?>" <? if($row_product['product_priority']==$i) {?> selected="selected"<? } ?>>
                    <?=$i?>
                    </option>
                  <?
				    }
				   ?>
                </select></td>
				
				
				
				
				
				<td align="left" class="table_details">
                <a href="add_artist_products.php?product=<?=$row_product['product_id'];?>&artist=<?=$user;?>"><img border="0" src="images/edit.png" title="Modify the Product" alt="Modify the Product" /></a>
                <a onclick="return show_confirm()" href="list_artist_products.php?product=<?=$row_product['product_id'];?>&artist=<?=$user;?>"><img border="0" src="images/delete.png" title="Delete this Product" alt="Delete this Product"/></a>                </td>
              
			  </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
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
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
