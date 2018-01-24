<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error' => '',
);
$this -> meta_description = $data['seo_description'];
Yii::app()->clientScript->registerMetaTag('noindex, follow', 'robots');
?>
<div style="margin:80px;">
	<h2>Error <?php echo $code; ?></h2>
	<div>
		<div class="error">
			<?php echo CHtml::encode($message); ?>
		</div>
		<div>			
			<p><h3>We can not find the page you are looking for.</h3><br/></p>
		</div>
	</div>
</div>