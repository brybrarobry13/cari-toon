<?
include('includes/configuration.php');
	$sortby=$_REQUEST['sortby'];
	$status_sort=$_REQUEST['sortbystatus'];
	$sortbydate=$_REQUEST['sortbydate'];
	$searchword = $_GET['keyword'];
	$first_date=$_REQUEST['first_date'];
	$last_date=$_REQUEST['last_date'];
	$sortbystatus='AND (T.`order_status`= \'completed\' OR T.`order_status`= \'artist paid\' OR T.`order_status`= \'Refunded\')';
	if($status_sort=='Completed')
	{
	$sortbystatus='AND T.order_status=\''.$status_sort.'\'';
	}
	if($status_sort=='artist paid')
	{
	$sortbystatus='AND T.order_status=\''.$status_sort.'\'';
	}
	if($status_sort=='Refunded')
	{
	$sortbystatus='AND T.order_status=\''.$status_sort.'\'';
	}
	if($sortbydate=='date_range')
	{
		if($first_date!="" )
		{
			$sortbydate=' AND DATE(T.order_date)>= \''.$first_date.'\'' ;
		}
		if($last_date!=""  )
		{
			$sortbydate.=' AND DATE(T.order_date) <=\''.$last_date.'\' ' ;
		}
		//$sortbydate='AND T.order_date BETWEEN \''.$first_date.'\' AND \''.$last_date.'\' ' ;
	}
	$sortorder=$_REQUEST['sortorder'];
	if($sortorder=='ascending')
	{
	$sort_order='ASC';
	}
	else
	{
	$sort_order='DESC';
	}
	if($sortby=='date')
	{
	$sort_by='T.order_date';
	}
	elseif($sortby=='artist')
	{
	$sort_by='TA.user_fname';
	}
	else
	{
	$sort_by='T.order_date';
	}
	$sql_content="SELECT T . * , TP . * , TA.`user_fname` , TA.`user_lname` FROM `toon_orders` T, `toon_products` TP, `toon_users` TA WHERE T.`product_id`= TP.`product_id` AND TA.`user_id`=T.`artist_id` $sortbystatus $sortbydate";
	if($searchword !="")
	{
		$sql_content.=" AND (
						TA.`user_fname` LIKE '%$searchword%' 
						OR TA.`user_lname` LIKE '%$searchword%' 
						) ";
	}
	$sql_content.="ORDER BY $sort_by $sort_order";
$rs_content = mysql_query($sql_content);
if(isset($_POST['download']))
{	
	$exel_headding="Ord. No. \t Artist \t Status  \t Ordered Date  \t Whole sale Price($) \t Retail sale Price($) \t <:nextline:> ";
	$exel_content="";
	for($val=0;$val<=$_POST['content_no'];$val++)
	{
		$exel_content.=$_POST['excel_data'.$val];
	}
$whole_sale=$_POST['whole_sale'];
$retail_sale=$_POST['retail_sale'];
$exel_total="\t \t \t Total \t ".$whole_sale." \t ".$retail_sale."  \t <:nextline:>";
$filename ="Payments".date('dMy').".xls";
$contents1=$exel_headding.$exel_content.$exel_total;
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
<script>
function search_default()
{
	document.getElementById('Search_box').value='';
}
function search_set()
{
	if(document.getElementById('Search_box').value=='')
		document.getElementById('Search_box').value='Enter keyword';
}
function goto_search(sortby)
{

	if(document.getElementById('sort_check').checked==true)
	{
		var key = document.getElementById('Search_box').value;
		var first_date = document.getElementById('first_date').value;
		var last_date = document.getElementById('last_date').value;
		if(first_date!="" && last_date!="" && key!='' && key!='Enter keyword')
		{
			var status=document.getElementById('orderstatus').value
			window.location="payments.php?first_date="+first_date+'&last_date='+last_date+'&sortbystatus='+status+'&sortbydate=date_range&keyword='+key;
		}
		else if(first_date!="" && last_date!="")
		{
			var status=document.getElementById('orderstatus').value
			window.location="payments.php?first_date="+first_date+'&last_date='+last_date+'&sortbystatus='+status+'&sortbydate=date_range';
		}
		else
		{
		return false;
		}
	}
	else if(document.getElementById('Search_box').value!='Enter keyword' || document.getElementById('Search_box').value=='')
	{
		var key = document.getElementById('Search_box').value;
		var status=document.getElementById('orderstatus').value
		window.location="payments.php?keyword="+key+'&sortbystatus='+status;
	}
	else
	{
		if(sortby)
		{
		window.location='payments.php?sortbystatus='+sortby;
		}
		else
		{
		return false
		}
	}
}

</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">Payments</td></tr>
      <tr><td height="40px;"></td>
      <td>
      <form>
        <table cellpadding="0" cellspacing="2" width="100%">
        	<tr>
            	<td colspan="2"><input type="checkbox" value="date_range" <? if($sortbydate){?> checked="checked"<? }?> name="sort_check" id="sort_check" /> Sort By Date Range
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <input type="text" id="first_date" value="<?=$first_date?>" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'first_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
                    &nbsp;&nbsp;&nbsp;<span style="color:#858585">(Start Date)</span>
             </td>
             <td style="padding-left:159px">
                   <select id="orderstatus" onchange="goto_search(this.value)" >
                        <option value="all">All</option>
                        <option value="Completed" <? if($status_sort=='Completed') { echo 'selected="selected"';}?>>Completed</option>
                        <option value="artist paid" <? if($status_sort=='artist paid') { echo 'selected="selected"';}?>>Artist Paid</option>
                        <option value="Refunded" <? if($status_sort=='Refunded') { echo 'selected="selected"';}?>>Artist Refunded</option>
                    </select>
                
                </td>
            </tr>
            <tr>
            	<td width="50%">
                    <input type="text" value="<?=$last_date?>" id="last_date" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'last_date', 'last_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="last_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
                    &nbsp;&nbsp;&nbsp;<span style="color:#858585">(End Date)</span>
                </td>
                 
                <td align="right">
                <input name="Input" id="Search_box" class="textField_search" value="<? if($searchword) {echo $searchword;}else{ echo "Enter keyword";} ?>" type="text" onClick="search_default()" onBlur="search_set()" onkeypress="if(event.keyCode==13){ goto_search() }" >
                <img style="vertical-align:inherit" type="image" src="images/search.gif" onClick="goto_search()">
                </td>
            </tr>
             
        </table>
       </form>
    </td>
      </tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($rs_content);
			if ($count)
			{?>
            <form action="payments.php" method="post">
				<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
      <tr class="heading_bg">
          <td class="sub_heading">Order Id</td>
          <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="payments.php?sortby=artist&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>">Artist</a></td>
          <td class="sub_heading">Status</td>
          <td>
		  <a class="sub_heading" style="padding-left:0px" href="payments.php?sortby=date&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>">Ordered Date</a>
          </td>
          <td class="sub_heading">Wholesale Price($)</td>
          <td class="sub_heading">Retail Price($)</td>
          <td class="sub_heading">Action</td>
	 </tr>
       <?
	   $i=0;
	   while($content=mysql_fetch_assoc($rs_content))
	   {
			
	   ?>
        <tr>
          <td align="left" class="table_details" ><?=$content['order_id']?></td>
          <td align="left" class="table_details" ><?=$content['user_fname'].' '.$content['user_lname']?></td>
          <td align="left" class="table_details" ><?=$content['order_status'] ?></td>
		  <td align="left" class="table_details" ><? echo date('m-d-Y',strtotime($content['order_date']))?></td>
          <td align="center" class="table_details" ><? if($content['order_status']=='Refunded'){echo '(';}?><?=number_format(round($content['order_wholesale_price'],2),2);?><? if($content['order_status']=='Refunded'){echo ')';}?></td>
          <td align="center" class="table_details" ><? if($content['order_status']=='Refunded'){echo '(';}?><?=number_format($content['order_price'],2); ?><? if($content['order_status']=='Refunded'){echo ')';}?></td>
          <td align="left" class="table_details"><a href="order_details.php?order_id=<?=$content['order_id'];?>"><img border="0" src="images/edit.png" title="View Deatils" alt="View Deatils"/></a></td>
        </tr>
         <? 
		 if($content['order_status']=='Refunded')
	   		{
				$whole_sale_total-=$content['order_wholesale_price'];
				$total-=$content['order_price'];
	   		}
	   else
			{
				$whole_sale_total+=$content['order_wholesale_price'];
				$total+=$content['order_price'];
			}
		$excel_content=$content['order_id']."\t".$content['user_fname']." ".$content['user_lname']."\t".$content['order_status']."\t".date('m-d-Y',strtotime($content['order_date']))."\t".number_format(round($content['order_wholesale_price'],2),2)."\t".number_format($content['order_price'],2)."\t <:nextline:>";
        $i++;
		?>
       <input type="hidden" value="<? echo str_replace('"',"",$excel_content);?>" name="excel_data<?=$i?>" />
        <?
	   }?>
        <input type="hidden" name="content_no" value="<?=$i?>" />
       <input type="hidden" name="whole_sale" value="<?=round($whole_sale_total,2)?>" />
       <input type="hidden" name="retail_sale" value="<?=round($total,2)?>" />
       <tr>
       		<td colspan="9">&nbsp;</td>
       </tr>
        <tr>
        	<td></td><td></td><td></td><td class="table_details"><b>Total :</b></td><td align="center" class="table_details"><b>$&nbsp;<?=number_format(round($whole_sale_total,2),2);?></b></td><td align="center" class="table_details"><b>$&nbsp;<?=number_format(round($total,2),2);?></b></td><td></td><td></td><td></td>
        </tr>
        <tr>
          <td height="40" colspan="5"></td><td><input type="submit" name="download" value="Download" /></td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table>
      		</form>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No Payments</td>
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