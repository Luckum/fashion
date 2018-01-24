<?php
/* @var $this SizesController */
/* @var $model SizeChartCat */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Size Categories') => array('control/sizes/index'),
    $model->name => array('view','id'=>$model->id),
    Yii::t('base', 'Update Size Category') => '',
);

?>

    <h1><?=Yii::t('base', 'Update Size Category'); ?> "<?php echo CHtml::encode($model->name); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>