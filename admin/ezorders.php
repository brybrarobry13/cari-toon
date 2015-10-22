<?
include('includes/configuration.php');

	$ezopro_id=$_REQUEST['ezopro_id'];
	$sortbydate=$_REQUEST['sort_check'];
	$first_date=$_REQUEST['first_date'];
	$last_date=$_REQUEST['last_date'];
	$status_sort=$_REQUEST['orderstatus'];
	$searchword = $_REQUEST['Search_box'];
	
	if($ezopro_id)
	{  
		$delete=mysql_query("DELETE FROM `toon_ez_order_products` WHERE `ezopro_id`='$ezopro_id'");
		$delete=mysql_query("DELETE FROM `toon_shipping_address` WHERE `ezopro_id`='$ezopro_id'");
	}

	$sql_content="SELECT TC.*,TEOP.*
										FROM `toon_cart`TC,`toon_ez_order_products`TEOP
										WHERE TEOP.cart_id=TC.cart_id
										AND TEOP.ezopro_paymentstatus='Paid'";
	if($searchword!=''&&$searchword!='Enter keyword')
	{									
	$sql_append=" AND TEOP.`ezopro_id` LIKE '$searchword'";
	}
	if($status_sort)
	{									
	$sql_append.=" AND TEOP.ezopro_orderstatus='$status_sort'";
	}
	if($sortbydate=='date_range')
	{
		if($first_date!="")
		{									
			$sql_append.=" AND DATE(TEOP.ezopro_posted) >= '$first_date' ";
		}
		if($last_date!="")
		{									
			$sql_append.=" AND DATE(TEOP.ezopro_posted)<='$last_date' ";
		}
		/*elseif($first_date!=""&&$last_date!=""&&$sortbydate=='date_range')
		{									
			$sql_append.=" AND TEOP.ezopro_posted BETWEEN '$first_date' AND '$last_date' ";
		}*/
	}	
	
	//echo $sql_content.$sql_append;								
	$rs_content = mysql_query($sql_content.$sql_append);
	if(isset($_POST['download']))
		{	
			$exel_headding="Ord. No. \t Customer \t Ordered Date \t Status \t <:nextline:> ";
			for($val=0;$val<=$_POST['content_no'];$val++)
			{
				$exel_content.=$_POST['excel_data'.$val];
			}
			$filename ="Ez Orders".date('dMy').".xls";
			$contents1=$exel_headding.$exel_content;
			$contents = str_replace("<:nextline:>","\n",$contents1);
			header('Content-type: application/ms-excel');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $contents;
			exit();
		
	   }
include ('includes/header.php');
?>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<script type="text/javascript">
function show_confirm()
{
	var r=confirm("Do you really want to delete this order?");
	return r;
    
}
function search_default()
{
	document.getElementById('Search_box').value='';
}
function search_set()
{
	if(document.getElementById('Search_box').value=='')
		document.getElementById('Search_box').value='Enter keyword';
}
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
	<td height="40px;"></td>
    <td>
    <form name="calender" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <table cellpadding="0" cellspacing="2" width="100%">
        	<tr>
            	<td colspan="2"><input type="checkbox" value="date_range" <? if($sortbydate){?> checked="checked"<? }?> name="sort_check" id="sort_check" /> Sort By Date Range
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <input type="text" name="first_date" id="first_date" value="<?=$first_date?>" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'first_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
             </td>
             <td style="padding-left:159px">
                   <select onchange="document.calender.submit()" id="orderstatus" name="orderstatus">
                        <option value="">All</option>
                       <!-- <option value="Accepted" <? if($status_sort=='Accepted') { echo 'selected="selected"';}?>>Accepted</option>
                        <option value="AssetsCollected" <? if($status_sort=='AssetsCollected') { echo 'selected="selected"';}?>>AssetsCollected</option>-->
                        <option value="In Production" <? if($status_sort=='In Production') { echo 'selected="selected"';}?>>In Production</option>
                        <!--<option value="Canceled" <? if($status_sort=='Canceled') { echo 'selected="selected"';}?>>Canceled</option>
                        <option value="Shipment" <? if($status_sort=='Shipment') { echo 'selected="selected"';}?>>Shipment</option>-->
                        <option value="CompleteShipment" <? if($status_sort=='CompleteShipment') { echo 'selected="selected"';}?>>CompleteShipment</option>
                    </select>
                
                </td>
            </tr>
            <tr>
            	<td width="50%">
                    <input type="text" value="<?=$last_date?>" id="last_date" name="last_date" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'last_date', 'last_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="last_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
                </td>
                 
                <td align="right">
                <input id="Search_box" name="Search_box" class="textField_search" value="<? if($searchword) {echo $searchword;}else{ echo "Enter keyword";} ?>" type="text" onClick="search_default()" onBlur="search_set()">
                <input style="vertical-align:inherit;" type="image" src="images/search.gif">
                </td>
            </tr>
             
        </table>
    </form>
    </td>
 </tr>
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">EZ Prints Orders</td></tr>
      <tr><td height="40px;"></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($rs_content);
			if ($count)
			{?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
                  <tr class="heading_bg">
                      <td class="sub_heading">Order Id</td>
                      <td class="sub_heading">Customer</td>
                      <td class="sub_heading">Ordered Date</td>
                      <td class="sub_heading">Status</td>
                      <td class="sub_heading">Actions</td>
                  </tr>
                   <?
                   while($content=mysql_fetch_assoc($rs_content))
                   {
                        $customer=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name FROM `toon_users` WHERE `user_id`='$content[user_id]'"));
                   ?>
                    <tr>
                      <td align="left" class="table_details" ><?=$content['ezopro_id']?></td>
                      <td align="left" class="table_details" ><?=$customer['name']?></td>
                      <td align="left" class="table_details" ><? echo date('m-d-Y',strtotime($content['ezopro_posted']))?></td>
                      <td align="left" class="table_details" ><? if($content['ezopro_orderstatus']==''){echo 'waiting for aproval';}else{echo $content['ezopro_orderstatus'];}?></td>
                      <td align="left" class="table_details"><a href="ezorder_details.php?ezopro_id=<?=$content['ezopro_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="View order details" alt="View order details" /></a>
                      <a onclick="return show_confirm()" href="ezorders.php?ezopro_id=<?=$content['ezopro_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this Order" alt="Delete this Order"/></a></td>
                    </tr>
                   <? 
				   if($content['ezopro_orderstatus']==''){ $status_excel='waiting for aproval';}else{$status_excel= $content['ezopro_orderstatus'];}
				   $excel_content=$content['ezopro_id']."\t".$customer['name']."\t".date('m-d-Y',strtotime($content['ezopro_posted']))."\t".$status_excel."\t <:nextline:>";
                    $i++;
					?>
					<input type="hidden" value="<? echo str_replace('"',"",$excel_content);?>" name="excel_data<?=$i?>" />
					<?
				   }?>
                   <input type="hidden" name="content_no" value="<?=$i?>" />
                     <tr>
                      <td height="40" colspan="4"></td><td><input type="submit" name="download" value="Download" /></td>
                    </tr>
                    <tr>
                      <td height="40" colspan="5"></td>
                    </tr>
                 </table>
      		</form>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No orders submitted</td>
			</tr>
		</table>
			<? } ?>
	   </td>
      <td width="2%">&nbsp;</td>
    </tr>
      <tr><td height="40" colspan="4"></td></tr>
   </table>
  </td>
 </tr>
</table>
<?	include("includes/footer.php");?>