<?php 
	$slug = basename(__FILE__, ".php");
	$page = Page::getPage($slug);

	if ($page) {
		$content = $page->getContentByLanguage();
	} else {
		throw new CHttpException(400, "Bad Request");
	}
?>

<?php
	echo $content->content;
?>