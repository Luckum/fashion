<?php
/* @var $this BlocksController */
/* @var $model HomepageBlock */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Homepage Block') => array('control/blocks/index' . $backParameters),
	$model->getContentByLanguage()->title => array('control/blocks/view', 'id' => $model->id),
	Yii::t('base', 'Update Homepage Block') => '',
);

?>

<h1><?=Yii::t('base', 'Update Homepage Block');?> "<?php echo CHtml::encode($model->getContentByLanguage()->title); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>