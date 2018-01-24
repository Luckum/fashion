<?php
$this->breadcrumbs = array(
    'Home' => array('members/index'),
    'Sell' => '',
);
// Комиссия.
$commission = $seller->comission_rate ?
    $seller->comission_rate * 100 :
    Yii::app()->params['payment']['default_comission_rate'] * 100;

$this->widget('application.components.ModalFlash', array(
    'acceptableFlashes' => array('product_add')
));

?>
    <div class="uk-block uk-margin-large-top">
        <div id="sell-container" class="uk-container uk-container-center">
            <div class="uk-text-center uk-margin-large-bottom">
                <div class="uk-h1 uk-margin-small-bottom uk-text-normal"><?= Yii::t('base', 'Sell with us') ?></div>
            </div>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'sell-form',
                'htmlOptions' => array(
                    'class' => 'uk-form uk-form-modal',
                    'enctype' => 'multipart/form-data',
                    'onsubmit' => 'return checkBeforeSubmit()'
                ),
                'enableClientValidation' => false,
            )); ?>

            <div class="uk-grid">
                <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-3-4 uk-width-small-1-1 uk-push-1-4">
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'brand_id', array('class' => 'uk-form-label')); ?>
                                <div class="uk-form-controls uk-form-select uk-margin-top">
                                    <input id="Product_brand_id" class="brand_input" type="text"/>
                                    <?php echo $form->error($model, 'brand_id'); ?>
                                    <input id="hidden-user-brand" name="Product[brand_id]" type="hidden"
                                           class="brand_hidden"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-margin-large-top">
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'parentCategory', array(
                                    'class' => 'uk-form-label',
                                    'label' => Yii::t('base', 'Category')
                                )); ?>
                                <div class="uk-form-controls uk-form-select uk-margin-top before-ready-hidden">
                                    <?php echo $form->dropDownList($model, 'parentCategory', Category::getParrentCategoryList(), array(
                                        'class' => 'js-select',
                                        'empty' => Yii:: t('base', 'select category'),
                                        'ajax' => array(
                                            'url' => CController::createUrl('/members/profile/getSubcategory'),
                                            'type' => 'POST',
                                            'update' => '#Product_category_id',
                                            'success' => 'function(data) {
                                                $("#Product_size_type")
                                                        .select2("destroy")
                                                        .empty()
                                                        .append($("<option/>").prop("value", "").text("select size"))
                                                        .select2();
                                                var pc = $("#Product_parentCategory").val();
                                                if (!pc) {
                                                    $("#Product_category_id")
                                                        .select2("destroy")
                                                        .empty()
                                                        .append($("<option/>").prop("value", "").text("select subcategory"))
                                                        .select2();
                                                    return false;
                                                }
                                                $("#Product_category_id")
                                                    .select2("destroy")
                                                    .html(data)
                                                    .select2();
                                            }'
                                        ),
                                        'options' => array($model->category_id ? $model->category->parent->id : '' => array('selected' => true))
                                    )); ?>
                                    <?php echo $form->error($model, 'parentCategory'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-form-row margin-top-small-screen">
                                <b><?php echo $form->label($model, 'category_id', array('label' => Yii::t('base', 'Subcategory') . "*:")); ?></b>
                                <div class="uk-form-controls uk-form-select uk-margin-top before-ready-hidden">
                                    <?php echo $form->dropDownList($model, 'category_id', array(), array(
                                        'class' => 'js-select',
                                        'empty' => Yii:: t('base', 'select subcategory'),
                                    )); ?>
                                    <?php echo $form->error($model, 'category_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-margin-large-top">
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'title', array('class' => 'uk-form-label')); ?>
                                <div class="uk-form-controls">
                                    <?php echo $form->textField($model, 'title', array('placeholder' => '')); ?>
                                    <?php echo $form->error($model, 'title'); ?>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'size_type', array('class' => 'uk-form-label')); ?>*
                                <div class="uk-form-controls uk-form-select uk-margin-top before-ready-hidden">
                                    <?php echo $form->dropDownList($model, 'size_type', array(), array('class' => 'js-select', 'empty' => Yii:: t('base', 'select size'))); ?>
                                </div>
                                <?php echo $form->error($model, 'size_type'); ?>
                            </div>
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'color', array('class' => 'uk-form-label')); ?>
                                <div class="uk-form-controls uk-form-select uk-margin-top before-ready-hidden">
                                    <?php echo $form->dropDownList($model, 'color', Yii:: app()->params['colors'], array('class' => 'js-select', 'empty' => Yii:: t('base', 'select color'))); ?>
                                </div>
                                <?php echo $form->error($model, 'color'); ?>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-form-row margin-top-small-screen">
                                <?php echo $form->labelEx($model, 'description', array('class' => 'uk-form-label')); ?>
                                <?php echo $form->textArea($model, 'description', array('class' => 'uk-margin-small-top description-textarea')); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>

                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-margin-top uk-text-style uk-text-wrap big-line-height">
                                <?php echo Yii::t('base', 'Please add as much information as possible'); ?>.
                                <br/>
                                <?php echo Yii::t('base', 'Some things to include'); ?>:
                                <ul style="margin-top: 0px;">
                                    <li><?php echo Yii::t('base', 'year of purchase'); ?></li>
                                    <li><?php echo Yii::t('base', 'retail price'); ?></li>
                                    <li><?php echo Yii::t('base', 'fit (true to size, runs small, oversize etc.)'); ?></li>
                                    <li><?php echo Yii::t('base', 'the cut'); ?></li>
                                    <li><?php echo Yii::t('base', 'actual tag size'); ?></li>
                                    <li><?php echo Yii::t('base', 'condition (any defects, marks, scratches etc.)'); ?></li>
                                    <li><?php echo Yii::t('base', 'material'); ?></li>
                                    <li><?php echo Yii::t('base', 'measurements (length, width, height, depth)'); ?></li>
                                    <li><?php echo Yii::t('base', 'receipt, certificate of authenticity, original packaging'); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="attributesBlock">
                        <?php
                        AttributeHelper::$model = $model;
                        if (!$model->isNewRecord) {
                            AttributeHelper::renderAttributesByProductId($model->id, true);
                        } else {
                            AttributeHelper::renderAttributesByCategoryId($model->category_id, true);
                        }
                        ?>
                    </div>
                    <div class="uk-grid uk-margin-large-top">
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1 uk-push-1-3">
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'condition', array('class' => 'uk-form-label')); ?>
                                <div class="uk-form-controls uk-form-select uk-margin-top before-ready-hidden">
                                    <?php echo $form->dropDownList($model, 'condition', Product::getConditions(), array(
                                        'class' => 'js-select',
                                        'empty' => Yii:: t('base', 'select condition'),
                                        'options' => array($model->condition ? $model->condition : '' => array('selected' => true))
                                    )); ?>
                                </div>
                                <?php echo $form->error($model, 'condition'); ?>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1 uk-push-1-3">
                            <div class="uk-margin-top uk-text-style uk-text-wrap big-line-height">
                                <?php echo Yii::t('base',
                                    '<b>New:</b> no signs of use, comes with original tags/labels/packaging/certificates.<br />
                                     <b>Very good:</b> worn once or twice, like new. No visible defects, shows slight signs of wear.<br />
                                     <b>Good:</b> worn occasionally, shows acceptable defects from wear, such as minor marks. <br />
                                     <b>Fair:</b> worn regularly, shows obvious signs of wear.<br />'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">
                            <div class="uk-block-divider uk-margin-large-top"></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-margin-large-top">
                        <div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">

                            <div class="uk-form-row uk-margin-bottom">
                                <?php echo CHtml:: label(Yii:: t('base', 'Images'), 'image', array('required' => true, 'class' => 'uk-form-label')); ?>
                            </div>

                            <div id="product-images" class="uk-grid uk-grid-width-large-1-5">
                                <!--Images # 1-->
                                <figure>
                                    <?=CHtml :: link('', '', array('class' => 'delete-item'))?>
                                    <?=CHtml :: fileField('files[]', '', array('class' => 'image-upload'))?>
                                    <?=$form -> hiddenField($model, 'image1', array('value' => empty($model -> image1) ? '' : $model -> image1))?>
                                    <?=$form -> labelEx($model, 'image1', array('class' => 'image-label'))?>
                                    <figcaption>
                                        <div class="cover-text">
                                            <?=Yii :: t('base', 'Cover image')?>
                                        </div>
                                        <div class="upload-progress">
                                            <div class="bar">&nbsp;</div>
                                        </div>
                                    </figcaption>
                                </figure>
                                <!--Images # 2-->
                                <figure>
                                    <?=CHtml :: link('', '', array('class' => 'delete-item'))?>
                                    <?=CHtml :: fileField('files[]', '', array('class' => 'image-upload'))?>
                                    <?=$form -> hiddenField($model, 'image2', array('value' => empty($model -> image2) ? '' : $model -> image2))?>
                                    <?=$form -> labelEx($model, 'image2', array('class' => 'image-label'))?>
                                    <figcaption>
                                        <div class="upload-progress">
                                            <div class="bar">&nbsp;</div>
                                        </div>
                                    </figcaption>
                                </figure>
                                <!--Images # 3-->
                                <figure>
                                    <?=CHtml :: link('', '', array('class' => 'delete-item'))?>
                                    <?=CHtml :: fileField('files[]', '', array('class' => 'image-upload'))?>
                                    <?=$form -> hiddenField($model, 'image3', array('value' => empty($model -> image3) ? '' : $model -> image3))?>
                                    <?=$form -> labelEx($model, 'image3', array('class' => 'image-label'))?>
                                    <figcaption>
                                        <div class="upload-progress">
                                            <div class="bar">&nbsp;</div>
                                        </div>
                                    </figcaption>
                                </figure>
                                <!--Images # 4-->
                                <figure>
                                    <?=CHtml :: link('', '', array('class' => 'delete-item'))?>
                                    <?=CHtml :: fileField('files[]', '', array('class' => 'image-upload'))?>
                                    <?=$form -> hiddenField($model, 'image4', array('value' => empty($model -> image4) ? '' : $model -> image4))?>
                                    <?=$form -> labelEx($model, 'image4', array('class' => 'image-label'))?>
                                    <figcaption>
                                        <div class="upload-progress">
                                            <div class="bar">&nbsp;</div>
                                        </div>
                                    </figcaption>
                                </figure>
                                <!--Images # 5-->
                                <figure>
                                    <?=CHtml :: link('', '', array('class' => 'delete-item'))?>
                                    <?=CHtml :: fileField('files[]', '', array('class' => 'image-upload'))?>
                                    <?=$form -> hiddenField($model, 'image5', array('value' => empty($model -> image5) ? '' : $model -> image5))?>
                                    <?=$form -> labelEx($model, 'image5', array('class' => 'image-label'))?>
                                    <figcaption>
                                        <div class="upload-progress">
                                            <div class="bar">&nbsp;</div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>

                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                            <div class="uk-margin-top uk-text-style uk-text-wrap big-line-height">
                                <?php echo Yii::t('base',
                                    '<div>Please upload at least 3 high quality photos.</div>
                                     <div><b>Image 1:</b> (the cover image) the item is fully shown, laid flat or hung up without any angle, light background</div>
                                     <div><b>Image 2:</b> back side of the item</div>
                                     <div><b>Image 3:</b> label, tag etc.</div>
                                     <div><b>Image 4:</b> details of the item, defects, scratches etc.</div>
                                     <div><b>Image 5:</b> item as it is worn, dust bag, box</div>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">
                            <div class="uk-block-divider uk-margin-large-top"></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-margin-large-top">
                        <div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">
                            <div id="seller-type" class="uk-form-controls">
                                <div class="uk-form-label uk-margin-small-bottom"><?php echo Yii::t('base', 'Seller'); ?><sup>*</sup>:</div>
                                <?php foreach ($seller -> getTypes() as $k => $v): ?>
                                    <input type="radio" id="seller_<?=$k?>"
                                           name="<?=get_class($seller)?>[seller_type]"
                                           value="<?=$k?>" <?=($seller -> seller_type === $k) ? 'checked' : ''?> />
                                    <label for="seller_<?=$k?>" onclick="">
                                        <span class="span-box"></span>
                                        <?= Yii::t('base', $v) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-margin-large-top">
                        <div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'price', array('class' => 'uk-form-label uk-margin-small-bottom')); ?>
                                <div class="uk-margin-bottom">
                                    <div class="uk-form-mini">
                                        <?php echo $form->textField($model, 'price', array('readonly' => $model->id ? true : false)); ?>
                                        <?php echo $form->error($model, 'price'); ?>
                                    </div>
                                    <span class="uk-margin-small-left">
                                        <?= Yii::t('base', 'you get'); ?> &euro; <span id="price_get"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($model->id) : ?>
                        <div class="uk-grid uk-margin-top">
                            <div class="uk-form-row">
                                <?php echo CHtml::label(Yii::t('base', 'type a new price'), 'Product[new_price]'); ?>
                                &euro;<?php echo CHtml::textField('Product[new_price]', ''); ?>
                                <?= Yii::t('base', 'you get'); ?> &euro; <span id="new_price_get"></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($model->isNewRecord): ?>
                        <div class="uk-grid uk-margin-large-top">
                            <div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">
                                <div class="form-group-checkbox uk-form-controls">
                                    <?php echo $form->checkBox($model, 'acceptTerms'); ?>
                                    <label for="Product_acceptTerms" class="label-checkbox">
                                        <span></span><?php echo Yii::t('base', 'I accept the '); ?>
                                        <a href="<?= $this->createAbsoluteUrl(UtilsHelper::getTermsAndConditionsLink()) ?>"
                                            target="_blank" class="uk-base-link">
                                            <?php echo Yii::t('base', 'Terms & Conditions'); ?>
                                        </a></label>
                                    <span class="checkbox_error" style="display:none; color:red; margin-top: 10px"><?= Yii::t('base', '*REQUIRED') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="uk-grid uk-margin-large-top">
                        <div
                            class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1 uk-text-right">
                            <button type="submit" id="submit-form" class="uk-button"><?php echo Yii::t('base', 'submit'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

    <script>
        function submitSellForm() {
            $('#sell-form').submit();
        }
        // Комиссия для продукта.
        var p_commission = <?php echo $seller->comission_rate >= 0 ?
            1 - $seller->comission_rate :
            1 - Yii::app()->params['payment']['default_comission_rate']; ?>;

        $(document).ready(function () {

            if(typeof select_init != 'undefined'){
                select_init();

                $('.before-ready-hidden').css('visibility', 'visible');
            }

            var selects = [
                '#Product_parentCategory',
                '#Product_category_id',
                '#Product_size_type',
                '#Product_color',
                '#Product_condition',
            ];
            var textboxes = [
                '#hidden-user-brand',
                '#Product_title',
                '#Product_price',
                '#Product_description',
                'textarea[data-textarea-required="1"]',
                '*[data-textbox-required="1"]'
            ];
            var images = [
                '#Product_image1',
                '#Product_image2',
                '#Product_image3'
            ];
            function selectSetError(el) {
               var response = true;
                if (el.val() == '') {
                    response = false;
                    el.parents('.uk-form-row').find('label').addClass('error');
                    el.parents('.uk-form-controls').addClass('error');
                } else {
                    el.parents('.uk-form-row').find('label').removeClass('error');
                    el.parents('.uk-form-controls').removeClass('error');
                }
                return response;
            }

            function selectCheckboxesError(el) {
                var response = true;
                if (el.length > 0) {
                    var checkedCnt = el.find(':checked').length;
                    if (checkedCnt > 0) {
                        el
                            .parent()
                            .find('.required_checkboxes')
                            .remove();
                    } else {
                        response = false;
                        el
                            .parent()
                            .find('label.uk-form-label')
                            .after('<span style="color:red;margin-left:15px;" class="required_checkboxes">*REQUIRED</span>')
                    }
                }
                return response;
            }

            function textboxSetError(el, _jid) {
                var response = true;
                if (el.length > 0) {
                    if (el.val() == '') {
                        response = false;
                        if (_jid == '#hidden-user-brand') {
                            el = $('#Product_brand_id');
                        }
                        el
                            .addClass('error')
                            .parent()
                            .addClass('error');
                        el.attr('placeholder', '    *REQUIRED');
                    } else {
                        if (_jid == '#hidden-user-brand') {
                            el = $('#Product_brand_id');
                        }

                        el
                            .removeClass('error')
                            .parent()
                            .removeClass('error');
                        el.attr('placeholder', '');
                    }
                }
                return response;
            }

            $(selects).each(function(index, el) {
                var jel = $(el);
                $(el).on('change', function(event, param1) {
                    if (param1 != 'simple') {
                        selectSetError(jel);
                    }
                });
            });
            $(textboxes).each(function(index, el) {
                if (el == '#hidden-user-brand') {
                    el = '#Product_brand_id';
                }
                var jel = $(el);
                $('#sell-form').on('keyup', el, function(event) {
                    textboxSetError(jel, el);
                });
                jel.on('blur', function(event) {
                    textboxSetError(jel, el);
                });
            });

            $("#submit-form").on('click', function(e) {
                var readyForSubmit = true;
                <?php if ($model->isNewRecord): ?>
                readyForSubmit = false;
                e.preventDefault();
                if($("#Product_acceptTerms").prop("checked")) {
                    $('.checkbox_error').hide();
                    readyForSubmit = true;
                } else {
                    $('.checkbox_error').show();
                }
                <?php endif; ?>

                for (var _id in selects) {
                    var chel = $(selects[_id]);
                    if (chel.length > 0) {
                        if (!selectSetError(chel)) {
                            readyForSubmit = false;
                        }
                    }
                }
                for (var _id in textboxes) {
                    var tel = $(textboxes[_id]);
                    if (tel.length > 0) {
                        if (!textboxSetError(tel, _id)) {
                            readyForSubmit = false;
                        }
                    }
                }

                for (var _id in images) {
                    var im = $(images[_id]);
                    if (im.length > 0) {
                        if (im.val() == '') {
                            readyForSubmit = false;
                            im.parent().find('label').addClass('error');
                        } else {
                            im.parent().find('label').removeClass('error');
                        }
                    }
                }

                $('*[data-checkboxes-required]').each(function(index, el) {
                    var jel = $(el);
                    var fres = selectCheckboxesError(jel)
                    readyForSubmit = readyForSubmit && fres;
                });

                if (readyForSubmit) {
                   <?php if (Yii::app()->member->isGuest): ?>
                   var href = $('#login_sell');
                   if (href.length > 0) {
                        var url = '<?= Yii:: app()->createUrl("/members/auth/login", array("withoutRedirect" => "check_if_user_is_guest")) ?>';
                        var wrapper = $('#login_content');

                        $.ajax({
                            'url': url,
                            success: function (data) {
                                if (data == '0') {
                                    submitSellForm();
                                } else {
                                    $(wrapper).html(data);
                                }
                            }
                        });
                   }
                   <?php else: ?>
                   submitSellForm();
                   <?php endif; ?>
                }
                return false;
            });

            var price = $('#Product_price').val();
            if (!isNaN(price)) {
                $('#price_get').text((price * p_commission).toFixed(2));
            }

            if ('<?=$model->category_id?>') {
                var p_cat = $('#Product_parentCategory');
                $.ajax({
                    url: globals.url + '/members/profile/getSubcategory',
                    data: {'Product': {'parentCategory': p_cat.val()}},
                    type: 'POST',
                    success: function (data) {
                        $("#Product_category_id")
                            .empty()
                            .append(data);
                        loadCatSizes(<?= (!empty($model->category_id)) ? $model->category_id : '""'?>, <?= ($model->isNewRecord && empty($model->errors)) ? 'false' : 'true' ?>, true);

                        $('#Product_category_id').off('change').on('change', function (event, param1) {
                            if (param1 != 'withoutLoadSizes') {
                                loadCatSizes(this.value, false);
                            }
                        });
                    }
                });
            } else {
                $('#Product_category_id').off('change').on('change', function (event, param1) {
                    if (param1 != 'withoutLoadSizes') {
                        loadCatSizes(this.value, false);
                    }
                });
            }

            $('#sell-form').on('focus', '#_brand_text', function (event) {
                var val = $(this).val();
                if (val == '<?= Yii:: t('base', 'type in brand') ?>') {
                    $(this).val('');
                }
            });

            $("#Product_acceptTerms").change(function() {
                if($("#Product_acceptTerms").prop("checked")) {
                    $('.checkbox_error').hide();
                } else {
                    $('.checkbox_error').show();
                }
            });

            $('.brand_input').autocomplete({
                source: <?php echo Brand::jquery_source(); ?>,
                select: function (event, ui) {
                    var item = ui.item;
                    $(this).val(item.label);
                    var hidden = $(this).parent().children('.brand_hidden');
                    $(hidden).val(item.value);
                    return false;
                }
            });

            <?php if(isset($model->brand)): ?>

            $('#Product_brand_id').val('<?php echo $model->brand->name; ?>');
            $('#hidden-user-brand').val('<?php echo $model->brand_id; ?>');

            <?php endif; ?>

            $('#Product_brand_id').off('paste keyup change').on('paste keyup change', function (event) {
                $('.brand_hidden').val($(this).val());
            });
        });

        function loadCatSizes(catId, changeSizeOnly, calledFirstTime) {
            var calledFirstTime = calledFirstTime || false;
            var szType = $('#Product_size_type');
            szType.empty();
            if (catId != '' && typeof catId != 'undefined') {
                var url = globals.url + '/members/size/getSizeListForSubCatAndAttributes';
                var data = {'category': catId, 'uikit': true};

                $.ajax({
                    url: url,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (calledFirstTime) {
                            var html = $("#Product_category_id").html();
                            $("#Product_category_id")
                                .select2("destroy")
                                .html(html)
                                .select2();
                            if ('<?=$model->category_id?>') {
                                $('#Product_category_id [value="<?=$model->category_id?>"]')
                                    .prop('selected', 'selected');
                            }
                            $('#Product_category_id').trigger('change', ['withoutLoadSizes']);
                        }

                        if (!response) return false;
                        szType
                            .prop('disabled', '')
                            .html(response.size_type);
                        if (calledFirstTime) {
                            var selectedSizeVal = "<?=$model->size_type?>";
                        } else {
                            var selectedSizeVal = "";
                        }

                        szType
                            .find('option[value="' + selectedSizeVal + '"]')
                            .prop('selected', 'selected')
                            .trigger('change', ['simple']);

                       if (!szType.find('option:not([value=""])').length) {
                            szType
                                .empty()
                                .append(new Option('<?=Yii::t('base', 'Category has no size')?>'))
                                .prop('disabled', 'disabled');
                        }
                        if (!changeSizeOnly) {
                            $('#attributesBlock').html(response.attributes);
                        }
                    }
                });
            } else {
                $('#attributesBlock').html('');
            }
        }

        var re = /^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g;

        $('#Product_price').keyup(function () {
            this.value = this.value.replace(re, '');
            $('#price_get').text(($('#Product_price').val() * p_commission).toFixed(2));
        });

        $('#Product_new_price').keyup(function () {
            this.value = this.value.replace(re, '');
            $('#new_price_get').text(($('#Product_new_price').val() * p_commission).toFixed(2));
        });

    </script>

<?php Yii :: app()
    -> clientScript
    -> registerScriptFile('/js/jquery/jquery.ui.widget.js', CClientScript :: POS_END)
    -> registerScriptFile('/js/jquery/jquery.iframe-transport.js', CClientScript :: POS_END)
    -> registerScriptFile('/js/jquery/jquery.fileupload.js', CClientScript :: POS_END)
    -> registerScriptFile('/js/ckeditor/ckeditor.js', CClientScript :: POS_END)
    -> registerScriptFile('/uikit/js/errorInput.js', CClientScript :: POS_END)
?>
<script>
    $(document).ready(function() {
        // Папка загрузки.
        var uploadFld = '/images/upload';
        // Максимальный размер загружаемого файла.
        var fMaxSize = parseInt('<?=ini_get('upload_max_filesize')?>') * 1024 * 1024;
        // Разрешенные к загрузке типы файлов.
        var mimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];
        /**
         * Инициализация FileUpload.
         */
        $('.image-upload').fileupload({
            'url' : location.origin + '/members/profile/fileUpload',
            'add' : function(e, data) {
                /**
                 * Пользователь выбрал изображение.
                 */
                var file = data.files[0];
                if ((typeof file.size != 'undefined'  &&
                     typeof file.type != 'undefined') &&
                    (file.size > fMaxSize || $.inArray(file.type, mimeTypes) === -1)) {
                    alert('<?=Yii::t('base', 'Too large size or inncorect file type!')?>');
                } else {
                    data.submit();
                }
            },
            'progressall' : function (e, data) {
                /**
                 * Шкала загрузки (progressbar).
                 */
                $(e.target)
                    .parent()
                    .find('.upload-progress')
                    .show()
                    .find('.bar')
                    .css('width', parseInt(data.loaded / data.total * 100, 10) + '%');
            },
            'done' : function (e, data) {
                // Показываем превьюшку загруженного изображения.
                var name = data.result.files[0].name;
                $(e.target)
                    .parent()
                    .find('a')
                    .show()
                    .off('click')
                    .on('click', function(e) {
                        remProdImage(e, name, $(this));
                    })
                    .parent()
                    .find('input[type="hidden"]')
                    .val(name)
                    .parent()
                    .css('background', 'url("' + uploadFld + '/thumbnail/' + name + '") center center no-repeat')
                    .find('label')
                    .hide()
                    .parent()
                    .find('.upload-progress')
                    .hide();
            },
            'dataType' : 'json'
        });
        $('div#product-images > figure')
            /**
             * Вызов системного диалогового окна выбора файла для загрузки.
             */
            .on('click', function() {
                $(this)
                    .find('input[type="file"]')
                    .get(0)
                    .click();
            })
            /**
             * Отображение загруженных изображений товара при редактировании.
             */
            .each(function() {
                var fname = $(this).find('input[type="hidden"]').val();
                if (fname.length) {
                    $(this)
                        .css('background', 'url("' + uploadFld + '/thumbnail/' + fname + '") center center no-repeat')
                        .find('label')
                        .hide()
                        .parent()
                        .find('a')
                        .show()
                        .off('click')
                        .on('click', function(e) {
                            remProdImage(e, fname, $(this));
                        });
                }
            });
        /**
         * Удаление изображения.
         */
        function remProdImage(e, fname, a) {
            e.stopPropagation();
            a
                .hide()
                .parent()
                .css('background', 'url("' + location.origin + '/images/upload-file.png") center center no-repeat')
                .find('input[type="hidden"]')
                .val('')
                .parent()
                .find('label')
                .show();
            var url = location.origin + '/members/profile/remProdImage';
            var data = {'fname' : fname};
            $.post(url, data);
        }

        /**
         * Request a change (проверка корректности пользовательских исправлений).
         */
        var p, attr, type, params;
        var marker = '?wrong_fields=';
        if ((p = location.href.indexOf(marker)) != -1) {
            params = decodeURIComponent(location.href.substr(p + marker.length)).split(',');
            for (p = 0; p < params.length; p++) {
                attr = $('[name="Product[' + params[p] + ']"]');
                if (attr.get(0).type == 'select-one') {
                    attr
                        .find('option:first')
                        .prop('selected', 'selected');
                } else {
                    if (attr.get(0).name.indexOf('image') != -1) {
                        attr
                            .closest('figure')
                            .addClass('error')
                            .css('background', 'url("' + location.origin + '/images/upload-file.png") center center no-repeat')
                            .find('label')
                            .show()
                            .closest('figure')
                            .find('img')
                            .hide();
                    } else {
                        attr
                            .data('old', attr.val())
                            .on('blur', function() {
                                if (!$(this).val().length) {
                                    return false;
                                }
                                if ($(this).val() == $(this).data('old')) {
                                    $(this).val('');
                                } else {
                                    $(this).addClass('wf');
                                }
                            })
                            .on('focus', function() {
                                if ($(this).hasClass('wf')) {
                                    $(this).removeClass('wf');
                                }
                            });
                    }
                    attr.val('');
                }
            }
            // Скрываем поле 'New price'.
            $('#Product_new_price')
                .closest('.uk-margin-top')
                .hide();
        }
        <?php if (Yii::app()->member->isGuest): ?>
            setTimeout(function () {
               var href = $('#login_sell');
               if (href.length > 0) {
                    var url = '<?= Yii:: app()->createUrl("/members/auth/login") ?>';
                    var wrapper = $('#login_content');

                    $.ajax({
                        'url': url,
                        success: function (data) {
                            if ($.trim($(wrapper).html()) == '') {
                                $(wrapper).html(data);
                            }
                        }
                    });
               }
            }, 3000);
        <?php endif; ?>
    });
    jQuery(document).ready(function($) {
        $('#login_main').click(function () {
            var url = '<?= Yii:: app()->createUrl("/members/auth/login", array("withoutRedirect" => "check_if_user_is_guest")) ?>';
            var wrapper = $('#login_content');

            $.ajax({
                'url': url,
                success: function (data) {
                    if (data == '0') {
                        $("#submit-form").trigger('click');
                    } else {
                        $(wrapper).html(data);
                    }
                }
            });

            return false; // without redirect
        });
    });
    var wasSubmitted = false;
    function checkBeforeSubmit(){
      if(!wasSubmitted) {
        wasSubmitted = true;
        return wasSubmitted;
      }
      return false;
    }
</script>