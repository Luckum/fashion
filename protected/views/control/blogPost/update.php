<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Posts') => array('control/blogPost/' . $backParameters),
    Yii::t('base', 'Update Blog Post') => '',
);
?>

<h1><?=Yii::t('base', 'Update Blog Post'); ?> '<?php echo CHtml::encode($model->title); ?>'</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>