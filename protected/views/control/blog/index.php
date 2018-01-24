<?php
    /**
     * @var $this BlogController.
     */
    $this->breadcrumbs=array(
        Yii::t('base', 'Control Panel')=>array('control/index'),
        Yii::t('base', 'Manage Static Pages') => '',
    );
?>

<h1>
    <?=Yii::t('base', 'Blog')?>
</h1>

<p><?php echo CHtml::link(Yii::t('base', 'Categories'), array('/control/blogCategory'), array('class' => 'btn btn-large btn-primary')); ?></p>
<p><?php echo CHtml::link(Yii::t('base', 'Posts'), array('/control/blogPost'), array('class' => 'btn btn-large btn-primary')); ?></p>
<p><?php echo CHtml::link(Yii::t('base', 'Comments'), array('/control/blogComment'), array('class' => 'btn btn-large btn-primary')); ?></p>