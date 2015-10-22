function MainToggle(maintgl_item) 
{
   if(document.getElementById('main_'+maintgl_item).style.display!="none") 
   {
      document.getElementById('main_'+maintgl_item).style.display="none";
	  document.getElementById("maincat_td_"+maintgl_item).style.backgroundColor="";
   } 
   else 
   {
      document.getElementById('main_'+maintgl_item).style.display="block";
	  document.getElementById("maincat_td_"+maintgl_item).style.backgroundColor="#FFAD23";
   }
}
function MainCollapse(maintgl_items) 
{
	var cal_cnt=document.getElementById("maintotal_cnt").value;
	for (i=1;i<cal_cnt;i++) 
	{
		if(maintgl_items!=i)
		{
			document.getElementById('main_'+i).style.display="none";
			document.getElementById("maincat_td_"+i).style.backgroundColor="";
		}
	}
	MainToggle(maintgl_items)
}

function SubToggle(subtgl_item) 
{
   if(document.getElementById('sub_'+subtgl_item).style.display!="none") 
   {
      document.getElementById('sub_'+subtgl_item).style.display="none";
	  document.getElementById("subcat_td_"+subtgl_item).style.backgroundColor="";
   } 
   else 
   {
      document.getElementById('sub_'+subtgl_item).style.display="block";
	  document.getElementById("subcat_td_"+subtgl_item).style.backgroundColor="#FFAD23";
   }
}
function SubCollapse(subtgl_items) 
{
   var cal_cnt=document.getElementById("subtotal_cnt").value;
   for (i=1;i<cal_cnt;i++) 
   {
   		if(subtgl_items!=i)
		{
    		document.getElementById('sub_'+i).style.display="none";
			document.getElementById("subcat_td_"+i).style.backgroundColor="";
		}
   }
   SubToggle(subtgl_items)
}
function maincat_td_mouseover(j)
{
	document.getElementById("maincat_td_"+j).style.backgroundColor="#FFAD23";
}
function maincat_td_mouseout(j)
{
	document.getElementById("maincat_td_"+j).style.backgroundColor="";
}
function subcat_td_mouseover(j)
{
	document.getElementById("subcat_td_"+j).style.backgroundColor="#FFAD23";
}
function subcat_td_mouseout(j)
{
	document.getElementById("subcat_td_"+j).style.backgroundColor="";
}
function td_mouseover(j)
{
	document.getElementById("td_"+j).style.backgroundColor="#FFAD23";
}
function td_mouseout(j)
{
	document.getElementById("td_"+j).style.backgroundColor="";
}
function image_mouseover(i)
{
document.getElementById("image_"+i).src='images/create_now_button_mouseover.gif'
}
function image_mouseout(i)
{
document.getElementById("image_"+i).src='images/create_now_button.gif'
}

function mouseover(i)
{
document.getElementById("left_top_"+i).innerHTML='<img src="images/lefttop_blue.gif" />'
document.getElementById("righttop_"+i).innerHTML='<img src="images/righttop_blue.gif" />'
document.getElementById("leftbtm_"+i).innerHTML='<img src="images/left_bottom.gif" />'
document.getElementById("rightbtm_"+i).innerHTML='<img src="images/right_bottom.gif" />'
document.getElementById("topshadow_"+i).className="merchandise_learn_top_shadow_mouseout"
document.getElementById("leftshadow_"+i).className="merchandise_learn_left_shadow_mouseout"
document.getElementById("rightshadow_"+i).className="merchandise_learn_right_shadow_mouseout"
document.getElementById("btmshadow_"+i).className="merchandise_learn_bottom_shadow_mouseout"
}
function mouseout(i)
{
document.getElementById("left_top_"+i).innerHTML='<img src="images/lefttop_orange.gif" />'
document.getElementById("righttop_"+i).innerHTML='<img src="images/righttop_orange.gif" />'
document.getElementById("leftbtm_"+i).innerHTML='<img src="images/leftbottom_orange.gif" />'
document.getElementById("rightbtm_"+i).innerHTML='<img src="images/rightorange_bottom.gif" />'
document.getElementById("topshadow_"+i).className="merchandise_learn_top_shadow_mouseover"
document.getElementById("leftshadow_"+i).className="merchandise_learn_left_shadow_mouseover"
document.getElementById("rightshadow_"+i).className="merchandise_learn_right_shadow_mouseover"
document.getElementById("btmshadow_"+i).className="merchandise_learn_bottom_shadow_mouseover"
}