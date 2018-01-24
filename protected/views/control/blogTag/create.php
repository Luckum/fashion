<?php
/* @var $this BlogTagController */
/* @var $model BlogTag */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Tags') => array('control/blogTag/' . $backParameters),
    Yii::t('base', 'Create Blog Tag(s)') => '',
);

?>

<h1><?=Yii::t('base', 'Create Blog Tag(s)'); ?></h1>

<?php $this->renderPartial('_form_multi', array('model'=>$model)); ?>