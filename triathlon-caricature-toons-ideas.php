<?  include("includes/configuration.php");
	$title_text = "Caricature Ideas:";
	include (DIR_INCLUDES.'header.php');
	include_once(DIR_FUNCTIONS."static.php");
	$static_code='PAGE_TOONS_FORYOU';
	$static=get_staticdetails($static_code); 
?> 
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />
<div id="content">
    <div style="height:5px;"></div>
    <div>
        <div class="foryou_top_curve"><img src="<?=$_SERVER['HTTP_HOST']?>images/contact_top_left_curve.gif" /></div>
        <div class="buy_now_middlestrip foryou_top_middlestrip_position"></div>
        <div class="float_left"><img src="<?=$_SERVER['HTTP_HOST']?>images/contact_top_right_curve.gif" /></div>
        <div class="clear_right">&nbsp;</div>
        <div class="affliate_content_middle_strip foryou_content_position">
            <div class="foryou_pencil_img"><img src="<?=$_SERVER['HTTP_HOST']?>images/pencil.gif" border="0" alt="toon me up" title="Toon me up" height="350px"  /></div>
        	<div align="center"><img src="<?=$_SERVER['HTTP_HOST']?>images/text.gif" border="0" alt="we can caricature toon it all" title="We can caricature toon it all" /></div>	
			<?
            $sql_ideas="SELECT * FROM `toons_ideas` ORDER BY ti_ref_name";
            $rs_ideas=mysql_query($sql_ideas);
            $count=mysql_num_rows($rs_ideas);
            ?>
            <table align="center" border="0" cellpadding="5" cellspacing="5" width="99%" style="padding-left:20px;height:100px;">
            <?
            $diff=ceil($count/3);
            while($result=mysql_fetch_array($rs_ideas))
            {
                $toonsmulti_array[] = $result;
            }
            for($i=0;$i<$diff;$i++) {
            ?>
            <tr> 
                <td class="text_blue"><a href="/toon_idea_gallery.php?toon_gallery_name=<?=$toonsmulti_array[0+$i]['ti_ref_link']?>"><?=$toonsmulti_array[0+$i]['ti_ref_name']?></a></td>			
                <td class="text_blue"><a href="/toon_idea_gallery.php?toon_gallery_name=<?=$toonsmulti_array[$diff+$i]['ti_ref_link']?>"><?=$toonsmulti_array[$diff+$i]['ti_ref_name']?></a></td>
                <td class="text_blue"><a href="/toon_idea_gallery.php?toon_gallery_name=<?=$toonsmulti_array[($diff*2)+$i]['ti_ref_link']?>"><?=$toonsmulti_array[($diff*2)+$i]['ti_ref_name']?></a></td>
            </tr>
            <? } ?>		
            </table>
       		<div style="clear:both">&nbsp;</div>
        </div>
        <div class="foryou_top_curve"><img src="<?=$_SERVER['HTTP_HOST']?>images/contact_btm_left_curve.gif" /></div>
        <div class="contact_middle_strip_btm foryou_btm_strip_position"></div>
        <div class="float_left"><img src="<?=$_SERVER['HTTP_HOST']?>images/contact_btm_right_curve.gif" /></div>
        <div class="buy_now_txt_btm_space clear_both">&nbsp;</div>
    </div>
</div>
<? include (DIR_INCLUDES.'footer.php') ?>