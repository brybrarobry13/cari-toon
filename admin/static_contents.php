<?
	include('includes/configuration.php');
	
	$sql_static="SELECT * FROM  toon_static";
	$rs_static=mysql_query($sql_static);
	include ('includes/header.php');
?>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" width="100%" colspan="4">Static Contents</td>
        </tr>
        <tr>
          <td height="40px;"></td>
        </tr>
        <tr>
          <td width="2%">&nbsp;</td>
          <td align="center"><?
		
		$number=mysql_num_rows($rs_static);
		if (count!=$number)
		{?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Static Contents</td>
                <td class="sub_heading" height="30">Actions</td>
                 </tr>
              <?
	   while($content=mysql_fetch_assoc($rs_static))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$content['static_page']?></td>
                <td align="left" class="table_details"><a href="edit_static.php?static_id=<?=$content['static_id'];?>"><img border="0" src="images/edit.png" title="Modify the Profile" alt="Modify the Profile" /></a></td>
              </tr>
       <? }?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
             </table>
        <? }
		else
		{?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Static Contents</td>
              </tr>
            </table>
       <? }?>
          </td>
          <td width="2%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
