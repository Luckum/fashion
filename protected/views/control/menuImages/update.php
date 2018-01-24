<?php
/* @var $this MenuImagesController */
/* @var $model MainMenuImages */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Main Menu Images') => array('control/menuImages/index' . $backParameters),
	Yii::t('base', 'Update Main Menu Images') => '',
);
?>

<h1>Update Main Menu Images</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>