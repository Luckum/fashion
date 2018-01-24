<?php
/* @var $this TemplatesController */
/* @var $model Template */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Email Templates') => array('control/templates' . $backParameters),
	$model->alias => array('control/templates/view', 'id' => $model->id),
	Yii::t('base', 'Update Email Template') => '',
);

?>

<h1><?=Yii::t('base', 'Update Email Template');?> "<?php echo CHtml::encode($model->alias); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>