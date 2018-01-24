<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Languages Settings') => array('control/settings/languages'),
    Yii::t('base', 'Create Language') => ''
);

?>

<h1><?= Yii::t('base', 'Create Language'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>