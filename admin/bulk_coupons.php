<?
	include('includes/configuration.php');
	//TO DELETE BULK COUPON
	$bulk_id =$_REQUEST['bulk_id'];
	$del=$_REQUEST['del'];
	$download = $_REQUEST['download'];
	
	if($bulk_id && $del)
	{
		$del_promo_bulk = mysql_query("delete from toon_promo_bulk where `bulk_id`='$bulk_id'");
		$del_promo=mysql_query("delete from toon_promo where `bulk_id`='$bulk_id'");
    }

	if($bulk_id && $download)
	{
		
		$sql_promo_bulk="SELECT * FROM  `toon_promo_bulk` WHERE `bulk_id`='$bulk_id'";
		$rs_promo_bulk=mysql_query($sql_promo_bulk);
		$row_promo_bulk=mysql_fetch_assoc($rs_promo_bulk);
		
		$exel_headding="Code \t Title \t Product  \t Discount \t Start Date \t End Date \t Status \t<:nextline:> ";
		$sql_promo="SELECT *,DATE_FORMAT(`promo_start_date`, '%m-%d-%y') as `promo_start_date`, DATE_FORMAT(`promo_expiry`, '%m-%d-%y') as `promo_expiry` FROM  `toon_promo` WHERE `bulk_id`='$bulk_id'";
		$rs_promo=mysql_query($sql_promo);
		$exel_content="";
		$index = 0;
		while($row_promo=mysql_fetch_assoc($rs_promo))
		{
			if ($row_promo['promo_isused'] == 0)
			{
				$isused = 'Not Used';
			} else {
				$isused = 'Used';
			}
			$excel_download_content=$row_promo['promo_code']."\t".$row_promo_bulk['bulk_title']."\t".$row_promo['promo_product_type']."\t".$row_promo['promo_discount']."\t".$row_promo['promo_start_date']."\t".$row_promo['promo_expiry']."\t".$isused."\t <:nextline:>";
			$excel_data.$index = str_replace('"',"",$excel_download_content);
			$exel_content.= $excel_data.$index;
			$index++;			
		}

		$filename ="Coupons_".$row_promo_bulk['bulk_title']."_".date('dMy').".xls";
		$contents1=$exel_headding.$exel_content;
		$contents = str_replace("<:nextline:>","\n",$contents1);
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $contents;
		exit();
		
	}
	
	$sql_bulk="SELECT *, DATE_FORMAT(TP.`promo_start_date`, '%m-%d-%y') as `promo_start_date`, DATE_FORMAT(TP.`promo_expiry`, '%m-%d-%y') as `promo_expiry` FROM `toon_promo`TP, `toon_promo_bulk`TPB WHERE TPB.`bulk_id`=TP.`bulk_id` GROUP BY TPB.`bulk_id`";
	$rs_bulk=mysql_query($sql_bulk);

	include ('includes/header.php');
 ?>
<script>
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Promotional Codes</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Generate Bulk Coupons"onclick="window.location='bulkcoupon_edit.php'" /></td>

        </tr>
       <!-- <tr><td></td><td style="padding-left:30px"><b>Toon Products</b></td></tr> -->
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_bulk);
		if ($number!=0)
		{
		?>
            <table cellpadding="4" cellspacing="0" width="95%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Title</td>
                <td class="sub_heading" height="30">#Coupons</td>
                <td class="sub_heading" height="30">Product Type</td>
                <td class="sub_heading" height="30">Discount</td>
                <td class="sub_heading" height="30">Date Range</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
              <?
	   while($row_bulk=mysql_fetch_assoc($rs_bulk))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_bulk['bulk_title']?></td>
                <td align="left" class="table_details"><?=$row_bulk['bulk_count']?></td>
                <td align="left" class="table_details"><?=$row_bulk['promo_product_type']?></td>
                <td align="left" class="table_details"><?=$row_bulk['promo_discount']; echo '(%)';?></td>
                <td align="left" class="table_details"><?=$row_bulk['promo_start_date']?> - <?=$row_bulk['promo_expiry']?></td>
                <td align="left" class="table_details"><a href="bulkcoupon_edit.php?bulk_id=<?=$row_bulk['bulk_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this Promotional Code" alt="Modify this Promotional Code" /></a> <a onclick="return confirmation()"href="bulk_coupons.php?bulk_id=<?=$row_bulk['bulk_id'];?>&del=1"><img border="0" src="images/delete.png" title="Delete this Promotional Code" alt="Delete this Bulk Coupon"/></a><a href="bulk_coupons.php?bulk_id=<?=$row_bulk['bulk_id'];?>&download=1"><img border="0" src="images/download.jpeg" title="Download this Promotional Code" alt="Download this Promotional Code"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
            </table>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Promotional Codes!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="5%">&nbsp;</td>
        </tr>
		<tr>
          <td height="20" colspan="4"></td>
        </tr>
		<tr>
			<td colspan="4">
				<table align="center">
					<tr><td align="center" class="table_details">Note:- This section provides randomly generated coupon codes that can only be used once. </td></tr>
				</table>
			</td>
		</tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
