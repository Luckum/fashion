<?php
class LinkPager extends CLinkPager {
	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		$pageCount=$this->getPageCount();
		// if(($pageCount=$this->getPageCount())<=1)
		// 	return array();
		Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createPageUrl(0));
		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();
		
		// prev page
		if ($this->prevPageLabel !== false) {
			if(($page=$currentPage-1)<0)
				$page=0;
			$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);
		}
		// first page
		if ($this->firstPageLabel !== false) {
			$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<$this->maxButtonCount-2,false);
			$buttons[]=$this->createPageButton('...',0,$this->firstPageCssClass,$currentPage<$this->maxButtonCount-2,false);
		}

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
		
		// last page
		if ($this->lastPageLabel !== false && $this->maxButtonCount < $this->pageCount) {
			$buttons[]=$this->createPageButton('...',$pageCount-1,$this->lastPageCssClass,$currentPage>$this->maxButtonCount+1,false);
			$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>$this->maxButtonCount+1,false);
		}
		// next page
		if ($this->nextPageLabel !== false) {
			if(($page=$currentPage+1)>=$pageCount-1)
				$page=$pageCount-1;
			$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);
		}

		return $buttons;
	}
}