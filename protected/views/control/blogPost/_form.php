<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';

Yii::app()->clientScript->registerScriptFile('/js/timezone_selecting.js', CClientScript::POS_END);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'blog-post-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model, 'timezone', array('id' => 'timezone')); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'short_description'); ?>
        <?php echo $form->textArea($model,'short_description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'short_description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>

    <div class="row">
        <?php if($model->image): ?>
            <?php echo CHtml::hiddenField('BlogPost[oldImage]', $model->image); ?>
            <?php echo CHtml::image(
                            Yii::app()->request->getBaseUrl(true) . '/images/blog/' . $model->image,
                            $model->image_title,
                            array('width'=>'150px', 'class'=>'blog_main_img')
                        );
            ?>
            <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image', array('required' => true)); ?>
        <?php echo $form->fileField($model,'image'); ?>
        <?php echo $form->error($model,'image'); ?>
        <div class="img-preview"></div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'image_title'); ?>
        <?php echo $form->textField($model,'image_title',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'image_title'); ?>
    </div>

    <div class="row">
        <span id="add_tags_btn"><?= Yii::t('base', 'Tags') ?> <i class="icon-plus"></i></span>
        <span class="tags">
            <?php if ($model->tags): ?>
                <?php foreach ($model->tags as $tag): ?>
                    <span class="tag label label-info">
                        <input value="<?= $tag->name ?>" type="hidden" name="<?= get_class($model) . '[tags][]' ?>">
                        <span><?= $tag->name ?></span>
                        <i class="remove_tag_btn remove icon-remove-sign icon-white"></i>
                    </span>
                <?php endforeach; ?>
            <?php endif; ?>
        </span>
    </div>

    <div class="row">
        <label for="<?= get_class($model) . '[categories][]' ?>"><?= Yii::t('base', 'Categories') ?></label>
        <?php   echo CHtml::dropDownList(
                    get_class($model) . '[categories][]',
                    CHtml::listData($model->categories, 'id', 'id'),
                    BlogCategory::getAllCategories(),
                    array('multiple' => 'multiple', 'id' => 'categories_multi_select'));
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'seo_title'); ?>
        <?php echo $form->textField($model,'seo_title'); ?>
        <?php echo $form->error($model,'seo_title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'seo_description'); ?>
        <?php echo $form->textArea($model,'seo_description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'seo_description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'allow_add_comments'); ?>
        <?php echo $form->checkbox($model,'allow_add_comments'); ?>
        <?php echo $form->error($model,'allow_add_comments'); ?>
    </div>

    <div class="row">
        <?php
            echo $form->labelEx($model,'publish_at');

            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $this->widget('CJuiDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'publish_at',
                'mode'=>'datetime',
                'options'=>array(
                    "dateFormat"=>'yy-mm-dd',
                    "timeFormat"=>'hh:mm:ss',
                )
            ));

            echo $form->error($model,'publish_at');
          ?>
    </div>

    <?php echo $form->hiddenField($model,'status',array('id' => 'hidden_status')); ?>

    <div class="form-actions">
        <div class="offset2">
            <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('base', 'Save as a draft'), array('class' => 'btn btn-primary save_draft'));
                    echo '&nbsp;';
                    echo CHtml::submitButton(Yii::t('base', 'Publish'), array('class' => 'btn btn-success save_publish'));
                    echo '&nbsp;';
                } else {
                    if (!$model->isPublished()) {
                        echo CHtml::submitButton(Yii::t('base', 'Publish'), array('class' => 'btn btn-success save_publish'));
                        echo '&nbsp;';
                    } else {
                        echo CHtml::submitButton(Yii::t('base', 'Save as a draft'), array('class' => 'btn btn-success save_draft'));
                        echo '&nbsp;';
                    }
                    echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-primary'));
                    echo '&nbsp;';
                }
                echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                    array('/control/blogPost/index') :
                    array('/control/blogPost/index/' . $backParameters)),
                    array('class' => 'btn btn-primary'));
            ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

function openKCFinder(field) {
    window.KCFinder = {
        callBack: function(url) {
            $(field).parents('.modal_slideshow_row').find('img.img-thumbnail').attr('src', url)
            window.KCFinder = null;
        }
    };
    window.open('/imagesfinder/browse.php?type=images&dir=uploads', 'kcfinder_modal',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}

function deleteRow(link) {
    if ($('tr.modal_slideshow_row').length == 1) {
        alert('<?=Yii::t('base', 'You cannot delete this item. Simply close this window') ?>');
        return false;
    }
    var $target = $(link).parents('tr.modal_slideshow_row');
    $target.hide('slow', function(){ $target.remove(); });
}

function addRow() {
    var newRow = $('.modal_table tr.modal_slideshow_row:first').clone();
    newRow.find('img').attr('src', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTZkYjYzNDZkNyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NmRiNjM0NmQ3Ij48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ1LjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=')
    $('.modal_table').append(newRow);
}

/**
 * Добавление слайд-шоу в пост.
 */
function addSliderToPost()
{
    var img_src, title, isEmpty = true;
    var rows = $('tr.modal_slideshow_row');

    // Генерация разметки слайдера.
    var html = '<div class="slider">'                               +
               '<div class="slide-list">'                           +
               '<div class="slide-wrap">';

    rows.each(function() {

        img_src = $(this).find('img').attr('src');
        title   = $(this).find('.modal_slideshow_description').val();
        if (img_src.indexOf('base64') === -1) {
            isEmpty = false;
        } else {
            return true;
        }
        if ($.trim(title) == '') {
            title = '&nbsp;';
        }

        html += '<div class="slide-item">' +
                '<img src="' + img_src + '" class="slide-img" alt="slide image"/>'   +
                '<span class="slide-title">' + title + '</span>'    +
                '</div>';

    });

    if (isEmpty) {
        alert('<?=Yii::t('base', 'You should add at least one image!') ?>');
        return;
    }

    html += '</div></div>'                                          +
            '<div class="navy prev-slide"></div>'                   +
            '<div class="navy next-slide"></div>'                   +
            '</div>';

    // Добавляем фрагмент в CKEditor.
    CKEDITOR.instances.BlogPost_content.insertElement(
        CKEDITOR.dom.element.createFromHtml(html)
    );

    // Закрываем диалоговое окно добавления слайдера.
    $('#slideshow_modal').dialog('close');
}

</script>

<div id="dialog" title="Add tag">
  <input id="new_tag" type="text">
  <br>
  <button id="add_new_tag" class="btn btn-primary">Add tag</button>
</div>

<script>
    function htmlEncode(s, preserveCR) {
        preserveCR = preserveCR ? '&#13;' : '\n';
        return ('' + s) /* Forces the conversion to string. */
            .replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
            .replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            /*
            You may add other replacements here for HTML only
            (but it's not necessary).
            Or for XML, only if the named entities are defined in its DTD.
            */
            .replace(/\r\n/g, preserveCR) /* Must be before the next replacement. */
            .replace(/[\r\n]/g, preserveCR);
    }

    function addTag() {
        var newTags = $('#new_tag').val();
        if (newTags == '') {
            alert('Tag cannot be empty!');
            return false;
        }
        var tags = newTags.split(',');
        for (var i in tags) {
            var newTag = $.trim(tags[i]);
            if (newTag == '') continue;
            var tag = '<span class="tag label label-info">' +
                '<input value="' + htmlEncode(newTag) + '" type="hidden" name="<?= get_class($model) . '[tags][]' ?>">' +
                '<span>' + newTag + '</span>' +
                '<i class="remove_tag_btn remove icon-remove-sign icon-white"></i>' +
            '</span>';
            $('.tags').append(tag);
        }

        $("#dialog").dialog("close");
    }

    jQuery(document).ready(function($) {

        $('#timezone').val(jstz.determine().name());

        $(document).on('click', '#add_tags_btn', function(event) {
            $('#new_tag').val('');
            $( "#dialog" ).dialog({
                position: { my: "left top", at: "right bottom", of: $('#add_tags_btn') },
                draggable: false
            });
        });

        $(document).on('click', '#add_new_tag', function(event) {
            addTag();
        });

        $(document).on('click', '#close_dialog', function(event) {
            $("#slideshow_modal").dialog("close");
        });

        $(document).on('keypress', '#dialog', function(event) {
            var key = event.which;
            if(key == 13) {
                addTag();
            }
        });

        $(document).on('click', '.remove_tag_btn', function(event) {
            $(this).parents('.tag').remove();
        });

        CKEDITOR.replace( 'BlogPost[content]', {
            filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/imagesfinder/browse.php?type=files',
            filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/imagesfinder/browse.php?type=images',
            filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/imagesfinder/browse.php?type=flash',
            filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/imagesfinder/upload.php?type=files',
            filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/imagesfinder/upload.php?type=images',
            filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/imagesfinder/upload.php?type=flash',
            on: {
                instanceReady: function( evt ) {
                    var btn = '<span role="toolbar" class="cke_toolbar">' +
                                    '<span role="presentation" class="cke_toolgroup">' +
                                        '<a id="add_showslider" aria-haspopup="false" aria-labelledby="cke_37_label" role="button" hidefocus="true" tabindex="-1" title="Add slideshow" class="cke_button cke_button__source cke_button_off" id="cke_37"><span style="background-image:url(\'/images/slideshow.png\');background-size:auto;" class="cke_button_icon">&nbsp;</span><span aria-hidden="false" class="cke_button_label cke_button__source_label" id="cke_37_label">Add slideshow</span></a>' +
                                    '</span>' +
                                '</span>';
                    $('#cke_BlogPost_content .cke_toolbox').append(btn);
                    $('#add_showslider').on('click', function(event) {
                        $('#slideshow_modal').dialog('open');
                    });
                }
            }
        });

        CKEDITOR.add;

        $('#tags_multi_select').multiselect();
        $('#categories_multi_select').multiselect();

        $('.save_publish').on('click', function(event) {
            $('#hidden_status').val('<?= BlogPost::POST_STATUS_PUBLISHED ?>');
            return true;
        });

        $('.save_draft').on('click', function(event) {
            $('#hidden_status').val('<?= BlogPost::POST_STATUS_DRAFTED ?>');
            return true;
        });

        $(document).on('click', '.remove_img_btn', function(event) {
            $('#BlogPost_oldImage').val('');
            $('.blog_main_img, .remove_img_btn').remove();
        });

        $('input[type="file"]').on('change', function() {
            var fReader;
            var imgPrew = $(this)
                .parent()
                .find('.img-preview')
                .empty();
            if (typeof (fReader = new FileReader) == 'undefined') {
                return false;
            }
            fReader.onload = function(e) {
                $('<img/>')
                    .attr('src', e.target.result)
                    .appendTo(imgPrew.show());
            };
            fReader.readAsDataURL($(this).get(0).files[0]);
        });
    });
</script>
<?php Yii::app()->clientScript->registerScriptFile('/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
<!--Bootstrap Multiselect-->
<?php Yii :: app()
    -> clientScript
    -> registerScriptFile('/js/bootstrap-multiselect.js', CClientScript :: POS_END)
    -> registerCssFile('/css/bootstrap-multiselect.css')
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'slideshow_modal',
        'options'=>array(
            'title'=>Yii::t('base', 'Add slideshow images'),
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'auto',
            'height'=>'auto',
            'resizable'=>'false',
        ),
    ));
?>
<div class="modal-content">
    <div class="modal-body">
        <table class="table table-striped modal_table">
            <tr class="modal_slideshow_row">
                <td style="min-width: 140px;">
                    <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTZkYjYzNDZkNyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NmRiNjM0NmQ3Ij48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ1LjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" alt="" class="img-thumbnail">
                </td>
                <td>
                    <p>
                        <label for=""><?=Yii::t('base', 'Image description') ?></label>
                        <input type="text" name="" class="modal_slideshow_description">
                        <button type="button" class="btn btn-primary" onclick="openKCFinder(this)"><?=Yii::t('base', 'Add image') ?></button>
                    </p>
                </td>
                <td>
                    <a onclick="deleteRow(this);return false;" href="#" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button id="close_dialog" type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('base', 'Close') ?></button>
        <button type="button" class="btn btn-primary" onclick="addRow()"><?=Yii::t('base', 'Add one more row') ?></button>
        <button type="button" class="btn btn-success" onclick="addSliderToPost()"><?=Yii::t('base', 'Create Slideshow') ?></button>
    </div>
</div>
<?php
    $this->endWidget();
 ?>