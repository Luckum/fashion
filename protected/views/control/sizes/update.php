<?php
/* @var $this SizesController */
/* @var $model SizeChart */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Sizes') => array('control/sizes/index'),
    $model->type.' '.$model->size => array('view','id'=>$model->id),
    Yii::t('base', 'Update Size') => '',
);

?>

    <h1><?=Yii::t('base', 'Update Size'); ?> "<?php echo CHtml::encode($model->type.' '.$model->size); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>