<?php
/* @var $this AttributeValueGroupController */
/* @var $model AttributeValueGroup */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Attribute defined values') => array('control/attributeValue'),
    Yii::t('base', 'Groups for defined values') => array('control/attributeValueGroup'),
    Yii::t('base', 'Update group for defined values')
);

?>

<h1><?=Yii::t('base', 'Update group');?> "<?php echo CHtml::encode($model->value); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>