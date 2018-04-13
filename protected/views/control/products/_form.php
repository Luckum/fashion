<?php
/* @var $this ProductsController */
/* @var $model Product */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
$category_id_for_external_sale = Category::model()->getExternalSaleCategoryId();
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'product-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <?php echo $form->labelEx($model,'external_sale'); ?>
        <?php echo $form->checkBox($model, 'external_sale'); ?>
        <?php echo $form->error($model,'external_sale'); ?>
        <input type="hidden" id="category_id_for_external_sale" name="category_id_for_external_sale" value="<?= $category_id_for_external_sale ?>" >
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'user_id'); ?>
        <?php echo $form->dropDownList($model, 'user_id', User::getAllUsers()); ?>
        <?php echo $form->error($model,'user_id'); ?>
        <?php echo CHtml::textField('Product[Invalid][user_id]', isset($invalidProd['user_id']) ? $invalidProd['user_id'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div id="isExternalSale_categoryId" class="row">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <?php echo $form->dropDownList($model,'category_id',Category::getSubCategoryList(), array('onchange' => 'reloadSizes(this)')); ?>
        <?php echo $form->error($model,'category_id'); ?>
        <?php echo CHtml::textField('Product[Invalid][category_id]', isset($invalidProd['category_id']) ? $invalidProd['category_id'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>
    <div id="attributesBlock">
        <?php 
            AttributeHelper::$model = $model;
            if (!$model->isNewRecord && empty($model->errors)) {
                AttributeHelper::renderAttributesByProductId($model->id);
            } else {
                AttributeHelper::renderAttributesByCategoryId($model->category_id);
            }
        ?>
            
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'brand_id'); ?>
        <?php echo $form->dropDownList($model,'brand_id',Brand::getAllBrands()); ?>
        <?php echo $form->error($model,'brand_id'); ?>
        <?php echo CHtml::textField('Product[Invalid][brand_id]', isset($invalidProd['brand_id']) ? $invalidProd['brand_id'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div id="isExternalSale_size" class="row">
        <?php echo $form->labelEx($model,'size_type'); ?>
        <?php echo $form->dropDownList($model,'size_type', array(), array('class' => 'size-type')); ?>
        <?php echo $form->error($model,'size_type'); ?>
    </div>

     <div id="isExternalSale_url" class="row">
        <?php echo $form->labelEx($model,'direct_url'); ?>
        <?php echo $form->textField($model,'direct_url',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'direct_url'); ?>
        <?php echo CHtml::textField('Product[Invalid][direct_url]', isset($invalidProd['direct_url']) ? $invalidProd['direct_url'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
        <?php echo CHtml::textField('Product[Invalid][title]', isset($invalidProd['title']) ? $invalidProd['title'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>10, 'cols'=>10)); ?>
        <?php echo $form->error($model,'description'); ?>
        <?php echo CHtml::textField('Product[Invalid][description]', isset($invalidProd['description']) ? $invalidProd['description'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php if($model->image1): ?>
            <?php echo CHtml::hiddenField('Product[oldImage1]', $model->image1); ?>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true)."/images/upload/".$model->image1,$model->title . '1',array('width'=>'150px', 'class'=>'old_image')); ?>
            <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image1', array('required' => true)); ?>
        <?php echo $form->fileField($model,'image1'); ?>
        <?php echo $form->error($model,'image1'); ?>
        <?php echo CHtml::textField('Product[Invalid][image1]', isset($invalidProd['image1']) ? $invalidProd['image1'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
        <div class="img-preview"></div>
    </div>

    <div class="row">
        <?php if($model->image2): ?>
            <?php echo CHtml::hiddenField('Product[oldImage2]', $model->image2); ?>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true)."/images/upload/".$model->image2,$model->title . '2',array('width'=>'150px', 'class'=>'old_image')); ?>
            <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image2', array('required' => true)); ?>
        <?php echo $form->fileField($model,'image2'); ?>
        <?php echo $form->error($model,'image2'); ?>
        <?php echo CHtml::textField('Product[Invalid][image2]', isset($invalidProd['image2']) ? $invalidProd['image2'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
        <div class="img-preview"></div>
    </div>

    <div class="row">
        <?php if($model->image3): ?>
            <?php echo CHtml::hiddenField('Product[oldImage3]', $model->image3); ?>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true)."/images/upload/".$model->image3,$model->title . '3',array('width'=>'150px', 'class'=>'old_image')); ?>
            <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image3', array('required' => true)); ?>
        <?php echo $form->fileField($model,'image3'); ?>
        <?php echo $form->error($model,'image3'); ?>
        <?php echo CHtml::textField('Product[Invalid][image3]', isset($invalidProd['image3']) ? $invalidProd['image3'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
        <div class="img-preview"></div>
    </div>

    <div id="isExternalSale_image">
        <div id="image4" class="row">
            <?php if($model->image4): ?>
                <?php echo CHtml::hiddenField('Product[oldImage4]', $model->image4); ?>
                <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true)."/images/upload/".$model->image4,$model->title . '4',array('width'=>'150px', 'class'=>'old_image')); ?>
                <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
            <?php endif; ?>
            <?php echo $form->labelEx($model,'image4'); ?>
            <?php echo $form->fileField($model,'image4'); ?>
            <?php echo $form->error($model,'image4'); ?>
            <?php echo CHtml::textField('Product[Invalid][image4]', isset($invalidProd['image4']) ? $invalidProd['image4'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
            <div class="img-preview"></div>
        </div>

        <div id="image5" class="row">
            <?php if($model->image5): ?>
                <?php echo CHtml::hiddenField('Product[oldImage5]', $model->image5); ?>
                <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true)."/images/upload/".$model->image5,$model->title . '5',array('width'=>'150px', 'class'=>'old_image')); ?>
                <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
            <?php endif; ?>
            <?php echo $form->labelEx($model,'image5'); ?>
            <?php echo $form->fileField($model,'image5'); ?>
            <?php echo $form->error($model,'image5'); ?>
            <?php echo CHtml::textField('Product[Invalid][image5]', isset($invalidProd['image5']) ? $invalidProd['image5'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
            <div class="img-preview"></div>
        </div>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image_url1'); ?>
        <?php echo $form->textField($model,'image_url1',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'image_url1'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image_url2'); ?>
        <?php echo $form->textField($model,'image_url2',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'image_url2'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image_url3'); ?>
        <?php echo $form->textField($model,'image_url3',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'image_url3'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image_url4'); ?>
        <?php echo $form->textField($model,'image_url4',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'image_url4'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image_url5'); ?>
        <?php echo $form->textField($model,'image_url5',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'image_url5'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'color'); ?>
        <?php echo $form->dropDownList($model,'color', Yii::app()->params['colors']); ?>
        <?php echo $form->error($model,'color'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label(Yii::t('base', 'Different color'),'Product[custom_color]'); ?>
        <?php echo CHtml::textField('Product[custom_color]',$model->color,array('size'=>60,'maxlength'=>255)); ?>
        <?php echo CHtml::textField('Product[Invalid][custom_color]', isset($invalidProd['custom_color']) ? $invalidProd['custom_color'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'custom_size'); ?>
        <?php echo $form->textField($model,'custom_size',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'custom_size'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'price'); ?>
        <?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'price'); ?>
        <?php echo CHtml::textField('Product[Invalid][price]', isset($invalidProd['price']) ? $invalidProd['price'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'init_price'); ?>
        <?php echo $form->textField($model,'init_price',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'init_price'); ?>
        <?php echo CHtml::textField('Product[Invalid][init_price]', isset($invalidProd['init_price']) ? $invalidProd['init_price'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>
    
    <?php /*
    <div class="row">
        <?php echo $form->labelEx($model,'item_number'); ?>
        <?php echo $form->textField($model,'item_number',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'item_number'); ?>
        <?php echo CHtml::textField('Product[Invalid][item_number]', isset($invalidProd['item_number']) ? $invalidProd['item_number'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>
    */ ?>

    <div class="row">
        <?php echo $form->labelEx($model,'condition'); ?>
        <?php echo $form->dropDownList($model,'condition',Product::getConditions()); ?>
        <?php echo $form->error($model,'condition'); ?>
        <?php echo CHtml::textField('Product[Invalid][condition]', isset($invalidProd['condition']) ? $invalidProd['condition'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'length'); ?>
        <?php echo $form->textField($model,'length',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'length'); ?>
        <?php echo CHtml::textField('Product[Invalid][length]', isset($invalidProd['length']) ? $invalidProd['length'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'width'); ?>
        <?php echo $form->textField($model,'width',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'width'); ?>
        <?php echo CHtml::textField('Product[Invalid][width]', isset($invalidProd['width']) ? $invalidProd['width'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'height'); ?>
        <?php echo $form->textField($model,'height',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'height'); ?>
        <?php echo CHtml::textField('Product[Invalid][height]', isset($invalidProd['height']) ? $invalidProd['height'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'depth'); ?>
        <?php echo $form->textField($model,'depth',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'depth'); ?>
        <?php echo CHtml::textField('Product[Invalid][depth]', isset($invalidProd['depth']) ? $invalidProd['depth'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <?php /*

    <div class="row">
        <?php echo $form->labelEx($model,'featured'); ?>
        <?php echo $form->textField($model,'featured',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'featured'); ?>
        <?php echo CHtml::textField('Product[Invalid][featured]', isset($invalidProd['featured']) ? $invalidProd['featured'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'featured_order'); ?>
        <?php echo $form->textField($model,'featured_order',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'featured_order'); ?>
        <?php echo CHtml::textField('Product[Invalid][featured_order]', isset($invalidProd['featured_order']) ? $invalidProd['featured_order'] : "", array('class' => 'invalid', 'style' => 'display: none')); ?>
    </div>

    */
    ?>

    <div class="row">
        <?php echo $form->labelEx($model,'our_selection'); ?>
        <?php echo $form->checkBox($model, 'our_selection'); ?>
        <?php echo $form->error($model,'our_selection'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status', $model->getStatuses()); ?>
        <?php echo $form->error($model,'status'); ?>
        <?php echo CHtml::textArea('Product[Declined]', '', array('class' => 'declined', 'style' => 'display: none')); ?>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                array('/control/products/index') :
                //array('/control/products/view', 'id' => $model->id)),
                array('/control/products/index/' . $backParameters)),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.remove_img_btn', function(event) {
            var parent = $(this).parents('.row').first();
            parent.find('input[id^="Product_oldImage"]').val('');
            parent.find('.old_image').remove();
            $(this).remove();
        });

        if ($("#Product_status").val() == 'invalid') {
            $(".invalid").show();
        };
        $("#Product_status").change(function() {
            if ($(this).val() == 'invalid') {
                $(".invalid").show();
                $(".declined").hide();
            } else if ($(this).val() == 'declined') {
                $(".invalid").hide();
                $(".declined").show();
            } else {
                $(".invalid").hide();
                $(".declined").hide();
            }
        });

        if($("#Product_external_sale").is(':checked')) {
            $("#isExternalSale_image").hide();
//            $('#isExternalSale_categoryId').hide();
            $("#isExternalSale_size").hide();
            $("#isExternalSale_url").show();
        } else {
            $("#isExternalSale_image").show();
            $("#isExternalSale_size").show();
            $('#isExternalSale_categoryId').show();
            $("#isExternalSale_url").hide();
        }

        $("#Product_external_sale").on('change', function() { 
            if($(this).is(":checked")) {
                //loadCatSizes($("#category_id_for_external_sale").val(),false);

                $("#isExternalSale_image").hide();
                $("#isExternalSale_size").hide();
                //$('#isExternalSale_categoryId').hide();
                $("#image4").find('.img-preview img').remove();
                $("#image4").find('.img-preview').css('display','none');

                $("#image5").find('.img-preview img').remove();
                $("#image5").find('.img-preview').css('display','none');
                $("#isExternalSale_url").show();
            } else {
                //$('#isExternalSale_categoryId').show();
                $("#isExternalSale_size").show();
                $("#isExternalSale_url").hide();
                $("#isExternalSale_url").val('');
                $("#isExternalSale_image").show();
            }
        });
        
        loadCatSizes(<?= (!empty($model->category_id)) ? $model->category_id : '""'?>, <?= ($model->isNewRecord && !$model->hasErrors()) ? 'false' : 'true' ?>);

        // ???????????? ??????????? ????? ????????? ?? ??????.
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
    function loadCatSizes(catId, changeSizeOnly) {
        var szType = $('.size-type');
        szType.empty();
        if (catId != '' && typeof catId != 'undefined') {
            var url    = globals.url + '/members/size/getSizeListForSubCatAndAttributes';
            var data   = {'category' : catId, 'uikit' : false};
            
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (!response) return false;
                    szType
                        .html(response.size_type)
                        .find('option[value="<?=$model->size_type?>"]')
                        .prop('selected', 'selected');
                    if (!changeSizeOnly) {
                        $('#attributesBlock').html(response.attributes);
                    }
                }
            });
        } else {
            $('#attributesBlock').html('');
        }
    }
    function reloadSizes(select) {
        loadCatSizes($(select).find('option:selected').val(), false);
    }
</script>

<?php Yii::app()->clientScript->registerScriptFile('/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
