<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Comments Settings - Moderate Comments') => array('control/settings/comments/moderate'),
    Yii::t('base', 'Edit Comments') => ''
);

?>

<?php
    $titleBeg = 'Edit ';
    $titleEnd = '';
    if (($type == 'c' && $model->comment_status == 'banned') || ($type == 'r' && $model->response_status == 'banned')) {
        $titleBeg .= 'Banned ';
    }
    if ($type == 'c') {
        $titleBeg .= 'Comment From User';
        $titleEnd = '&nbsp;"' .  CHtml::encode($model->user->username) . '"&nbsp;' . Yii::t('base', 'To Seller') . '&nbsp;"' . CHtml::encode($model->product->user->username) . '"';
    } else {
        $titleBeg .= 'Response From Seller';
        $titleEnd = '&nbsp;"' .  CHtml::encode($model->product->user->username) . '"&nbsp;' . Yii::t('base', 'To User') . '&nbsp;"' . CHtml::encode($model->user->username) . '"';
    }
?>
<h4><?= Yii::t('base', $titleBeg) . $titleEnd ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'banned-comments-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <div class="row">
        <label for="banned_comments"><?php if ($type == 'c'): echo Yii::t('base', 'Comment'); else: echo Yii::t('base', 'Response'); endif; ?></label>
        <textarea name="banned_comments" rows="8" style="width: 70%"><?php if ($type == 'c'): echo CHtml::encode($model->comment); else: echo CHtml::encode($model->response); endif; ?></textarea>
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/settings/comments/view', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
            <?php if (($type == 'c' && $model->comment_status == 'banned') || ($type == 'r' && $model->response_status == 'banned')): ?>
                <?php echo CHtml::submitButton(Yii::t('base', 'Save and Publish'), array('class' => 'btn btn-success', 'name' => 'publish')); ?>
            <?php endif; ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>