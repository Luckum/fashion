<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Manage Users') => array('control/users' . $backParameters),
    Yii::t('base', 'Update User') => ''
);

?>

<h1><?=Yii::t('base', 'Update User'); ?> "<?php echo CHtml::encode($model->username); ?>"</h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model,
    'sellerModel' => $sellerModel,
    'backParameters' => $backParameters)); ?>