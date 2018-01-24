<?php
    /* @var $this BlocksController */
    /* @var $model HomepageBlock */
    /* @var $form CActiveForm */

    CHtml::$afterRequiredLabel = '';
?>

<?php echo CHtml::hiddenField('url', Yii::app()->getBaseUrl(true).Yii::app()->urlManager->createUrl('site/products')); ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'block-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php
        $languages = UtilsHelper::getLanguages();
        $tabs = '';
        $content = '';
        for($i = 0; $i < count($languages); $i++) {
            if (isset($_POST['title_'.$languages[$i]])) {
                $contentTitle = $_POST['title_'.$languages[$i]];
            } else {
                $contentTitle = $model->getContentByLanguage($languages[$i])->title;
            }

            if (isset($_POST['content_'.$languages[$i]])) {
                $contentCont = $_POST['content_'.$languages[$i]];
            } else {
                $contentCont = $model->getContentByLanguage($languages[$i])->content;
            }

            $contentBlock = $model->getContentByLanguage($languages[$i]);

            $blockContentCk = "<textarea name=\"content_".$languages[$i]."\" class=\"ckeditor\">".$contentCont."</textarea>" .
                    $form->error($model, 'content_' . $languages[$i]) .
                   "<script type=\"text/javascript\">
                      CKEDITOR.replace( 'content_+".$languages[$i]."' );
                      CKEDITOR.add
                   </script>";
            $tabs .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';
            $content .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'">
            <div class="row">' .
                $form->labelEx($contentBlock,'title') .
                $form->textField(
                    $model,
                    'title_' . $languages[$i],
                    array(
                        'name' => 'title_' . $languages[$i],
                        'value' => $contentTitle
                    )
                ) .
                $form->error($model, 'title_' . $languages[$i]) .
                '</div>
            <div class="row">' . $form->labelEx($contentBlock,'content') . $blockContentCk . '</div>
            </div>';

        }
    ?>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <?=$tabs;?>
        </ul>
        <div class="tab-content">
            <?=$content;?>
        </div>
    </div>

    <div class="row">
        <?php if($model->image): ?>
            <?php echo CHtml::hiddenField('HomepageBlock[oldImage]', $model->image); ?>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl(true) . '/images/upload/blocks/' . $model->image, $model->getContentByLanguage()->title,array('width'=>'150px', 'class'=>'block_main_img')); ?>
            <img class="remove_img_btn" src="<?= Yii::app()->request->getBaseUrl(true) . "/images/rem-prod-img.png" ?>" alt="Remove image">
        <?php endif; ?>
        <?php echo CHtml::activeLabel($model, 'image', array('required' => true)); ?>
        <?php echo $form->fileField($model,'image'); ?>
        <?php echo $form->error($model,'image'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'link_type'); ?>
        <?php echo $form->dropDownList($model,'link_type', $model->getLinkType()); ?>
        <?php echo $form->error($model,'link_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'visible'); ?>
        <?php echo $form->checkBox($model, 'visible'); ?>
        <?php echo $form->error($model, 'link_type'); ?>
    </div>

    <div id="set_filters" <?php if ($model->isNewRecord || (!$model->isNewRecord && $model->link_type != HomepageBlock::FILTER_LINK)): ?> style="display: none;" <?php endif; ?>>
        <div class="row">
            <?php echo CHtml::label(Yii::t('base', 'Filters'), 'filters'); ?>
        </div>
        <div class="row checkboxgroup">
            <?php foreach ($model->getFilters() as $key => $value) : ?>
                <div class="f-chk">
                    <?php echo CHtml::checkBox('HomepageBlock[filters][' . $key . ']'); ?>
                    <?php echo CHtml::label($key, 'HomepageBlock[filters][' . $key . ']'); ?>
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
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                array('/control/blocks/index') :
                array('/control/blocks/index'  . $backParameters)),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScriptFile('/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/filtersList.js', CClientScript::POS_END); ?>

<!--Bootstrap Multiselect-->
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
        $('#HomepageBlock_link_type').on('change', function() {
            var fContainer = $('#set_filters');
            if ($(this).val() == '<?= HomepageBlock::FILTER_LINK; ?>') {
                fContainer.show();
            } else {
                fContainer.hide();
                $("#HomepageBlock_url").val('');
            }
        });
        $(document).on('click', '.remove_img_btn', function(event) {
            $('#HomepageBlock_oldImage').val('');
            $('.block_main_img, .remove_img_btn').remove();
        });
        <?php if ($model -> link_type == HomepageBlock :: FILTER_LINK): ?>
            try {
                var f_data = <?=json_encode(FilterHelper :: sortFilterParameters($model -> url))?>;
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