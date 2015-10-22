<?
	include('includes/configuration.php');
	$spo_id=$_REQUEST['spo_id'];
	if(isset($_POST['submit']))
	{
		$spl_title=$_POST['spl_title'];
		$spl_desc=$_POST['spl_desc'];
		$spl_discount=$_POST["spl_discount"];
		$spl_pdt_type=$_POST["spl_pdt_type"];
		$spl_startdate=$_POST["spl_startdate"];
		$spl_enddate=$_POST["spl_enddate"];
		if($spo_id)
		{
		$sql_update="UPDATE `toon_special_offers` SET `spo_title` = '$spl_title',`spo_description` = '$spl_desc',`spo_discount` = '$spl_discount',`spo_startdate` = '$spl_startdate',`spo_enddate` = '$spl_enddate',`spo_product` = '$spl_pdt_type' WHERE `spo_id` ='$spo_id'";	
		$update_spo=mysql_query($sql_update);
		}
		else
		{
		$sql_insert=mysql_query("INSERT INTO `toon_special_offers` (`spo_title` ,`spo_description` ,`spo_discount` ,`spo_startdate` ,`spo_enddate` ,`spo_product`)VALUES ('$spl_title', '$spl_desc', '$spl_discount', '$spl_startdate','$spl_enddate', '$spl_pdt_type')");
		}
		header("Location:spl_offers.php");
	}
	$sql_spo="SELECT * FROM `toon_special_offers` WHERE `spo_id`='$spo_id'";
	$rs_spo = mysql_query($sql_spo);
	$row_spo=mysql_fetch_assoc($rs_spo);
	
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("spl_title").value=="")
    	{      
		 		document.getElementById("title_div").style.display="block";
				valid=false;
     	}
		if(document.getElementById("spl_desc").value=="")
    	{      
		 		document.getElementById("desc_div").style.display="block";
				valid=false;
     	}
		if((document.getElementById("spl_discount").value=="")||(isNaN(document.getElementById("spl_discount").value)))
    	{      
		 		document.getElementById("discount_div").style.display="block";
				valid=false;
     	 		
		}
	 	if(document.getElementById("spl_startdate").value=="")
   		{
     			document.getElementById("startdate_div").style.display="block";
	 			valid=false;
    	}
		if(document.getElementById("spl_enddate").value=="")
   		{
     			document.getElementById("enddate_div").style.display="block";
	 			valid=false;
    	}
		
		return valid;
}
function clear()
{
		document.getElementById("title_div").style.display="none";
		document.getElementById("desc_div").style.display="none";
		document.getElementById("discount_div").style.display="none";
		document.getElementById("startdate_div").style.display="none";
		document.getElementById("enddate_div").style.display="none";
			
}

</script>
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<form action="" method="post" name="spl_offers_edit">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Special Offers</td>
          </tr>
          <tr>
            <td height="40px;"></td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="4" cellspacing="0" width="70%" class="table_border">
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td ><div id="title_div" style="display:none" class="no_details_msg">Enter the Title</div>
                    <div id="desc_div" style="display:none" class="no_details_msg">Enter the Description</div>
                    <div id="discount_div" style="display:none" class="no_details_msg">Enter the Discount</div>
                    <div id="startdate_div" style="display:none" class="no_details_msg">Enter the Start Date</div>
                    <div id="enddate_div" style="display:none" class="no_details_msg">Enter the End Date</div>
                    </td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Title&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="spl_title" id="spl_title" value="<?=$row_spo['spo_title'];?>" /></td>
                </tr>
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="36%" align="left" class="table_details">Description&nbsp;:*</td>
                  <td width="53%" align="left"><input type="text" name="spl_desc" id="spl_desc" value="<?=$row_spo['spo_description'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Discount(%)&nbsp;:*</td>
                  <td align="left"><input type="text" name="spl_discount" id="spl_discount" value="<?=$row_spo['spo_discount'];?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">&nbsp;</td>
                  <td align="left"><input type="radio" name="spl_pdt_type" checked="checked" value="ez product" />Ez Product
				  <input type="radio" name="spl_pdt_type" <? if($row_spo['spo_product']=="Toon product"){ echo 'checked="checked"';}?>  value="Toon product" />Toon Product
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Start Date&nbsp;:*</td>
                  <td align="left" ><input type="text" name="spl_startdate" value="<?=$row_spo['spo_startdate'];?>"id="spl_startdate" onClick="showChooser(this, 'pass_startdate', 'startcal_from', 1900, 2028, 'Y-m-d', false);"/>
                    &nbsp;<img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'spl_startdate', 'startcal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="startcal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 145px"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">End Date&nbsp;:*</td>
                  <td align="left" ><input type="text" name="spl_enddate" value="<?=$row_spo['spo_enddate'];?>"id="spl_enddate" onClick="showChooser(this, 'pass_enddate', 'endcal_from', 1900, 2028, 'Y-m-d', false);"/>
                    &nbsp;<img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'spl_enddate', 'endcal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="endcal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 145px"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left" ><input type="submit" name="submit" value=<? if($spo_id){?>"Update" <? }else{?>"Submit"<? }?>onclick="return valid()"/></td>
                </tr>
                <td align="left"></td>
                </tr>
              </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="49" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?	include("includes/footer.php");?>
