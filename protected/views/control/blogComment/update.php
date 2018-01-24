<?php
/* @var $this BlogCommentController */
/* @var $model BlogComment */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Comments') => array('control/blogComment/' . $backParameters),
    Yii::t('base', 'Update Blog Comment') => '',
);
?>

<h1><?=Yii::t('base', 'Update Blog Comment'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>