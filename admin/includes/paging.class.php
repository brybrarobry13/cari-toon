<?php


	class paging
	{
		// CONSTRUCTOR
		function paging()
		{
			$this->PageCount=6; // Total page numbers displayed
			$this->AcnhorClass='leftlink_txtblack'; // Class given to the anchor tags in this pagenation
			$this->TextClass='text_blue_content'; // Class given to the text in this pagenation
		}
		
		//SET THE CURRENT PAGE NUMBER
		function setPageNumber($pageno)
		{
			if($pageno>0)
				$this->PageNumber=$pageno;
			else
				$this->PageNumber=0;
				
			return $this->PageNumber;
		}
		
		// SET THE MAXIMUM NUMBER OF ROWS DISPLAYED IN A PAGE
		function setDisplayRows($maxrows)
		{
			$this->DisplayRows=$maxrows;
			return $this->DisplayRows;
		}
		
		// SET THE FIRST ROW DISPLAYED
		function setStartRow()
		{
			$this->StartRow	=$this->PageNumber*$this->DisplayRows;
			if($this->StartRow>0)
				return $this->StartRow;
			else
				return 0;
		}
		
		// SET THE TOTAL NUMBER OF PAGES TO DISPLAY THE WHOLE RESULTS
		function setTotalPages($totalrows)
		{
			$this->TotalPages=ceil($totalrows/$this->DisplayRows);
			return $this->TotalPages;
		}
		
		// URL
		function setURL($pagename)
		{
			$this->URL=$pagename;			
		}

		// PAGEING FUNCTION
		function pagenation()
		{
			
			// Style for Anchor tags	
			if($this->AcnhorClass=='')
				$a_class='';
			else
				$a_class='class="'.$this->AcnhorClass.'"';
			
			// Style for texts
			if($this->TextClass=='')
				$text_class='';
			else
				$text_class='class="'.$this->TextClass.'"';
			
			// Display FIRST & PREV Links, if not the first page
			if($this->PageNumber!=0)
				echo '<a href="'.$this->URL.'page='.($this->PageNumber-1).'" '.$a_class.' onmouseout="MM_swapImgRestore()" onmouseover=MM_swapImage("Image44","","images/arrow_leftover.jpg","1")><img src="images/arrow_left.jpg" name="Image44" width="19" height="16" border="0" id="Image44" /></a>';
				
			// Display page numbers 1 2 3 etc
			if($this->TotalPages!=1)
			{
				// Change the total page numbers displayed to the smallest of TOTAL PAGES & PAGE COUNT VARIABLE
				$show_count = ($this->TotalPages < $this->PageCount)?$this->TotalPages:$this->PageCount;
				
				if($this->TotalPages > $this->PageCount)
				{
					$max_right=ceil($show_count/2);
					$min_left=$max_right-1;
					if((($this->PageNumber+1+$max_right) <= $this->TotalPages) && (($this->PageNumber+1) - $min_left >0))
						$page=($this->PageNumber+1) - $min_left;
					elseif(($this->PageNumber+1) - $min_left <=0)
						$page=1;						
					else
						$page=$this->TotalPages-$show_count+1;
				}
				else
				{
					$page=1;
				}
				for($i=1;$i<=$show_count;$i++)
				{
					if($page==$this->PageNumber+1)
						echo '<span '.$text_class.'><b> '.$page.' </b></span>&nbsp;';
					else            
						echo '<a href="'.$this->URL.'page='.($page-1).'" '.$a_class.'> '.$page.' </a>&nbsp;';
					if($page==$this->TotalPages)
						break;
					$page++;
                    echo '|';
				}	
			}
			else
			{
				echo '<span '.$text_class.'><b> 1 </b></span>&nbsp;';
			}
			// Display NEXT & LAST Links, if not the last page
			if($this->PageNumber < ($this->TotalPages-1))
				echo '<a href="'.$this->URL.'page='.($this->PageNumber+1).'" '.$a_class.' onmouseout="MM_swapImgRestore()" onmouseover=MM_swapImage("Image45","","images/arrow_rightover.jpg",1)><img src="images/arrow_right.jpg" name="Image45" width="19" height="16" border="0" id="Image45" /></a>';
		}
	}
?>
