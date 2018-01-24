<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs = array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'SEO Settings') => '',
);

?>

<h1><?= Yii::t('base', 'SEO Settings'); ?></h1>

<!--SITE MAP UPLOAD-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'site_map_dialog',
    'options' => array(
        'title' => Yii::t('base', 'upload site map'),
        'autoOpen' => false,
        'modal' => true,
        'buttons' => array(
            Yii::t('base', 'Upload') => 'js:upload_site_map',
            Yii::t('base', 'Close') => 'js:function(){ $(this).dialog("close"); }'
        )
    )
));
?>

<div>
    <form id="site_map_form" enctype="multipart/form-data">
        <input type="file" name="site_map"/>
    </form>

    <div id="site_map_response"></div>
</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php echo CHtml::link(
    Yii::t('base', 'upload site map'), '#', array(
    'onclick' => '$("#site_map_dialog").dialog("open"); return false;'
)); ?>

<script type="text/javascript">
    function upload_site_map() {
        var validExtension = 'text/xml';
        var color_error = '#ff0000';
        var color_success = '#39751F';
        var div_response_show = '#site_map_response';
        var message_choose_file = '<?php echo Yii::t('base', 'choose file'); ?>';
        var message_invalid_extension = '<?php echo Yii::t('base', 'use only xml'); ?>';
        var success_show_element =
            '<span style="font-weight: bold; color: ' + color_success + ';">' +
            '<?php echo Yii::t('base', 'Site map is uploaded'); ?>' +
            '</span>' +
            '<br /><br />' +
            '<input type="text" value="{0}" style="width: 95%;" />';

        var form_data = new FormData($('#site_map_form')[0]);
        var file = form_data.get('site_map');

        // ----------- client validation
        //
        if (file == '') {
            $(div_response_show).html(message_choose_file).css('color', color_error);
            return;
        } else {
            if (file.type != validExtension) {
                $(div_response_show).html(message_invalid_extension).css('color', color_error);
                return;
            }
        }

        $.ajax({
            type: 'post',
            url: '/control/settings/seo/siteMap',
            data: form_data,
            datatype: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                var response = null;
                var message = null;
                var color = '#000000';

                try {
                    response = JSON.parse(data);
                } catch (e) {
                    response = null;
                }

                if (response != null) {
                    message =
                        response.type == 'error' ? response.message : success_show_element.replace('{0}', response.message);

                    color = response.type == 'error' ? color_error : color;
                } else {
                    message = 'invalid json';
                    color = color_error;
                }

                $(div_response_show).html(message).css('color', color);
            }
        });
    }
</script>
<!--END SITE MAP UPLOAD-->

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'seo-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <div class="row">
        <label for="site_name"><?= Yii::t('base', 'Site Name'); ?></label>
        <input type="text" name="site_name" value="<?= CHtml::encode($data['site_name']); ?>">
    </div>

    <div class="row">
        <label for="meta_description"><?= Yii::t('base', 'Meta Description'); ?></label>
        <textarea name="meta_description" rows="7"><?= CHtml::encode($data['meta_description']); ?></textarea>
    </div>

    <div class="row">
        <label for="meta_keywords"><?= Yii::t('base', 'Meta Keywords'); ?></label>
        <textarea name="meta_keywords" rows="7"><?= CHtml::encode($data['meta_keywords']); ?></textarea>
    </div>

    <div class="row">
        <label for="google_analytics_account"><?= Yii::t('base', 'Google Analytics Account'); ?></label>
        <input type="text" name="google_analytics_account"
               value="<?= CHtml::encode($data['google_analytics_account']); ?>">
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>