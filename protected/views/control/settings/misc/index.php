<?php
    $this -> breadcrumbs = array(
        Yii :: t('base', 'Control Panel') => array('control/index'),
        Yii :: t('base', 'Common Settings')  => '',
    );
?>

<h1><?=Yii::t('base', 'Common Settings');?></h1>

<div class="form">

    <?php $form = $this -> beginWidget('CActiveForm', array(
        'id'=>'misc-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Admin e-mail'), 'adminEmail')?>
        <?=CHtml :: textField('adminEmail', $data['adminEmail'], array('onfocus' => 'this.select()'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Facebook ID'), 'facebook_id')?>
        <?=CHtml :: textField('facebook_id', $data['facebook_id'], array('onfocus' => 'this.select()'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Facebook URL'), 'facebook_url')?>
        <?=CHtml :: textField('facebook_url', $data['facebook_url'], array('onfocus' => 'this.select()'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Twitter URL'), 'twitter_url')?>
        <?=CHtml :: textField('twitter_url', $data['twitter_url'], array('onfocus' => 'this.select()'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Instagram URL'), 'instagram_url')?>
        <?=CHtml :: textField('instagram_url', $data['instagram_url'], array('onfocus' => 'this.select()'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Blog URL'), 'blog_url')?>
        <?=CHtml :: textField('blog_url', $data['blog_url'], array('onfocus' => 'this.select()'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'QuickBooks Demo Mode'), 'quickBooks_IsDemo')?>
        <?=CHtml::dropDownList('quickBooks_IsDemo', $data['quickBooks_IsDemo'], array('0' => 'false', '1' => 'true'))?>
    </div>

    <div class="row">
        <?=CHtml :: label(Yii :: t('base', 'Deactivate "make offer" and "add comment" functions for business sellers'), 'business_deactive')?>
        <?=CHtml::dropDownList('business_deactive', $data['business_deactive'], array('0' => 'false', '1' => 'true'))?>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>
