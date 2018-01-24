<?php
/* @var $this MenuImagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('/control/index'),
	Yii::t('base', 'Manage Main Menu Images') => '',
);
?>

<h1><?=Yii::t('base', 'Manage Main Menu Images');?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'menuimages-grid',
	'dataProvider'=>$model->search(),
	'enableHistory' => true, 
	'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/menuImages/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'block_type',
		'image1',
		'link1_type',
		'url1',
		'image2',
		'link2_type',
		'url2',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
            'htmlOptions' => array('width' => '10%'),
		),
	),
)); ?>