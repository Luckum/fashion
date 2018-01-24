<?php
/* @var $this PagesController */
/* @var $model Page */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Pages') => array('control/pages' . $backParameters),
	$model->slug => array('control/pages/view', 'id' => $model->id),
	Yii::t('base', 'Update Page') => '',
);

?>

<h1><?=Yii::t('base', 'Update Page');?> "<?php echo CHtml::encode($model->slug); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>