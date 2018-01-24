<?php
/* @var $this MenuImagesController */
/* @var $model MainMenuImages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'main-menu-images-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <p><span class="required">Note that the first image should have a resolution of 620x415, the second picture - 475x715</span></p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'block_type'); ?>
		<?php echo $form->dropDownList($model, 'block_type', $model->getBlockType()); ?>
		<?php echo $form->error($model,'block_type'); ?>
	</div>

    <div id="first_block">
	<div class="row">
        <?php if($model->image1): ?>
            <?php echo CHtml::hiddenField('MainMenuImages[oldImage1]', $model->image1); ?>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true) . '/images/upload/blocks/' . $model->image1, ' ',array('width'=>'150px', 'class'=>'block_main_img block_img_1')); ?>
            <img class="remove_img_btn remove_1" id="remove_1" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image1', array('required' => true)); ?>
        <?php echo $form->fileField($model,'image1'); ?>
        <?php echo $form->error($model,'image1'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'link1_type'); ?>
		<?php echo $form->dropDownList($model, 'link1_type', $model->getLinkType()); ?>
		<?php echo $form->error($model,'link1_type'); ?>
	</div>

	<div id="set_filters" <?php if ($model->isNewRecord || (!$model->isNewRecord && $model->link1_type != MainMenuImages::FILTER_LINK)): ?> style="display: none;" <?php endif; ?>>
        <div class="row">
            <?php echo CHtml::label(Yii::t('base', 'Filters'), 'filters'); ?>
        </div>
        <div class="row checkboxgroup">
            <?php foreach ($model->getFilters() as $key => $value) : ?>
                <div class="f-chk">
                    <?php echo CHtml::checkBox('MainMenuImages[filters][' . $key . ']'); ?>
                    <?php echo CHtml::label($key, 'MainMenuImages[filters][' . $key . ']'); ?>
                </div>
                <?php if ($key == 'Brand') : ?>
                    <div id="filterBrand">
                        <?php echo CHtml::dropDownList($value, '', Brand::getAllBrands(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Color') : ?>
                    <div id="filterColor">
                        <?php echo CHtml::dropDownList($value, '', Yii::app()->params['colors'], array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Category') : ?>
                    <div id="filterCategory">
                        <?php echo CHtml::dropDownList($value, '', Category::getFullSubCategoryList(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Size') : ?>
                    <div id="filterSize">
                        <?=CHtml::dropDownList(
                            FilterHelper::SizeFilterParameterName,
                            '',
                            CHtml::listData(SizeChartCat::model()->findAll(), 'id', 'name'),
                            array('empty' => 'Select size category', 'class' => 'size-cat')
                        )?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Seller') : ?>
                    <div id="filterSeller">
                        <?php $seller = new SellerProfile ?>
                        <?php echo CHtml::dropDownList($value, '', $seller->getTypes(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Condition') : ?>
                    <div id="filterCondition">
                        <?php $product = new Product; ?>
                        <?php echo CHtml::dropDownList($value, '', Product::getConditions(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <div class="clearfix"></div>
            <?php endforeach; ?>
        </div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'url1'); ?>
		<?php echo $form->textField($model,'url1',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url1'); ?>
	</div>
    </div>
	<div id="second_block">
	<div class="row">
        <?php if($model->image2): ?>
            <?php echo CHtml::hiddenField('MainMenuImages[oldImage2]', $model->image2); ?>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true) . '/images/upload/blocks/' . $model->image2, ' ',array('width'=>'150px', 'class'=>'block_main_img block_img_2')); ?>
            <img class="remove_img_btn remove_2" id="remove_2" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image2'); ?>
        <?php echo $form->fileField($model,'image2'); ?>
        <?php echo $form->error($model,'image2'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'link2_type'); ?>
		<?php echo $form->dropDownList($model, 'link2_type', $model->getLinkType()); ?>
		<?php echo $form->error($model,'link2_type'); ?>
	</div>

		<div id="set_filters_2" <?php if ($model->isNewRecord || (!$model->isNewRecord && $model->link2_type != MainMenuImages::FILTER_LINK)): ?> style="display: none;" <?php endif; ?>>
        <div class="row">
            <?php echo CHtml::label(Yii::t('base', 'Filters'), 'filters'); ?>
        </div>
        <div class="row checkboxgroup">
            <?php foreach ($model->getFilters() as $key => $value) : ?>
                <div class="f-chk">
                    <?php echo CHtml::checkBox('MainMenuImages[filters2][' . $key . ']'); ?>
                    <?php echo CHtml::label($key, 'MainMenuImages[filters2][' . $key . ']'); ?>
                </div>
                <?php if ($key == 'Brand') : ?>
                    <div id="filter2Brand">
                        <?php echo CHtml::dropDownList($value, '', Brand::getAllBrands(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Color') : ?>
                    <div id="filter2Color">
                        <?php echo CHtml::dropDownList($value, '', Yii::app()->params['colors'], array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Category') : ?>
                    <div id="filter2Category">
                        <?php echo CHtml::dropDownList($value, '', Category::getFullSubCategoryList(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Size') : ?>
                    <div id="filter2Size">
                        <?=CHtml::dropDownList(
                            FilterHelper::SizeFilterParameterName,
                            '',
                            CHtml::listData(SizeChartCat::model()->findAll(), 'id', 'name'),
                            array('empty' => 'Select size category', 'class' => 'size-cat')
                        )?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Seller') : ?>
                    <div id="filter2Seller">
                        <?php $seller = new SellerProfile ?>
                        <?php echo CHtml::dropDownList($value, '', $seller->getTypes(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <?php if ($key == 'Condition') : ?>
                    <div id="filter2Condition">
                        <?php $product = new Product; ?>
                        <?php echo CHtml::dropDownList($value, '', Product::getConditions(), array('multiple' => 'multiple')); ?>
                    </div>
                    <br/>
                <?php endif; ?>

                <div class="clearfix"></div>
            <?php endforeach; ?>
        </div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'url2'); ?>
		<?php echo $form->textField($model,'url2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url2'); ?>
	</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScriptFile('/js/filtersList.js', CClientScript::POS_END); ?>

<?php Yii :: app()
    -> clientScript
    -> registerScriptFile('/js/bootstrap-multiselect.js', CClientScript :: POS_END)
    -> registerCssFile('/css/bootstrap-multiselect.css')
?>

<script type="text/javascript">
    $(document).ready(function() {
        /**
         * Смена типа ссылки.
         */
        $('#MainMenuImages_link1_type').on('change', function() {
            var fContainer = $('#set_filters');
            if ($(this).val() == '<?= MainMenuImages::FILTER_LINK; ?>') {
                fContainer.show();
            } else {
                fContainer.hide();
                $("#MainMenuImages_url1").val('');
            }
        });

         $('#MainMenuImages_link2_type').on('change', function() {
            var fContainer = $('#set_filters_2');
            if ($(this).val() == '<?= MainMenuImages::FILTER_LINK; ?>') {
                fContainer.show();
            } else {
                fContainer.hide();
                $("#MainMenuImages_url2").val('');
            }
        });

        $(document).on('click', '#remove_1', function(event) {
            $('#MainMenuImages_oldImage1').val('');
            $('.block_img_1, .remove_1').remove();
        });
        $(document).on('click', '#remove_2', function(event) {
            $('#MainMenuImages_oldImage2').val('');
            $('.block_img_2, .remove_2').remove();
        });
        $('#MainMenuImages_block_type').on('change', function() {
           if($(this).val() == '<?= MainMenuImages::TWO_IMAGES; ?>') {
           		$('#second_block').show();
                $('#first_block').show();
           } else if($(this).val() == '<?= MainMenuImages::NO_IMAGES; ?>') {
                $('#first_block').hide();
                $('#MainMenuImages_oldImage1').val('');
                $("#MainMenuImages_image1").val('');
                $('#MainMenuImages_link1_type').val('');
                $('#MainMenuImages_url1').val('');
           		$('#second_block').hide();
                $('#MainMenuImages_oldImage2').val('');
                $("#MainMenuImages_image2").val('');
           } else {
                $('#first_block').show();
                $('#second_block').hide();
                $('#MainMenuImages_oldImage2').val('');
                $("#MainMenuImages_image2").val('');
           }
        });
        <?php if($model->block_type == MainMenuImages::ONE_IMAGE): ?>
        	$('#second_block').hide();
        <?php elseif($model->block_type == MainMenuImages::NO_IMAGES): ?>
            $('#second_block').hide();
            $('#first_block').hide();
        <?php endif; ?>
        <?php if ($model -> link1_type == MainMenuImages :: FILTER_LINK): ?>
            try {
                var f_data = <?=json_encode(FilterHelper :: sortFilterParameters($model -> url1))?>;
                $.each(f_data, function(key, data) {
                    if (data.length) {
                        var filterDiv = $('#' + key).parent();
                        filterDiv
                            .show()
                            .prev('.f-chk')
                            .find('input[type="checkbox"]')
                            .prop('checked', 'checked');
                        for (var i = 0; i < data.length; i++) {
                            filterDiv
                                .find('option[value="' + data[i] + '"]')
                                .prop('selected', 'selected');
                        }
                    }
                });
            } catch (e) {
                // JSON parse error.
            }
        <?php endif; ?>
        <?php if ($model -> link2_type == MainMenuImages :: FILTER_LINK): ?>
            try {
                var f_data = <?=json_encode(FilterHelper :: sortFilterParameters($model -> url2))?>;
                $.each(f_data, function(key, data) {
                    if (data.length) {
                        var filterDiv = $('#' + key).parent();
                        filterDiv
                            .show()
                            .prev('.f-chk')
                            .find('input[type="checkbox"]')
                            .prop('checked', 'checked');
                        for (var i = 0; i < data.length; i++) {
                            filterDiv
                                .find('option[value="' + data[i] + '"]')
                                .prop('selected', 'selected');
                        }
                    }
                });
            } catch (e) {
                // JSON parse error.
            }
        <?php endif; ?>
    });
</script>