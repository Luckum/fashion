<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'alerts-form',
    'htmlOptions' => array(
        'class' => 'uk-form uk-form-modal'
    ),
    'enableClientValidation' => true
)); ?>

<?php //echo $form->errorSummary($model); ?>

<div class="uk-grid">
    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'category_id', array(
                'class' => 'uk-form-label'
            )); ?>
            <div class="uk-form-controls uk-form-select uk-margin-small-top before-ready-hidden">
                <?php echo $form->dropDownList($model,'category_id', array(''=>'select category') + Category::getParrentCategoryList(), 
                    array(
                        'class'=>'js-select',
                        'ajax' => array(
                            'type'=>'POST',
                            'url'=>CController::createUrl('/members/profile/getSubcategory'),
                            'update'=>'#Alerts_subcategory_id'
                        ),
                        'options' => array($model->category_id ? $model->category_id : '' => array('selected'=>true))
                    )
                ); ?>
                <?php echo $form->error($model,'category_id'); ?>
            </div>
        </div>
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'subcategory_id', array(
                'class' => 'uk-form-label'
            )); ?>
            <div class="uk-form-controls uk-form-select uk-margin-small-top before-ready-hidden">
                <?php echo $form->dropDownList(
                    $model,
                    'subcategory_id',
                    ($model->category_id) ? Category::getSubCategoryList($model->category_id, false) : array(''=>'select subcategory'), 
                    array(
                        'class'    => 'js-select sub-cat',
                        'options'  => array($model->subcategory_id ? $model->subcategory_id : '' => array('selected'=>true)),
                        'onchange' => 'setSizeType(this)'
                    )
                ); ?>
                <?php echo $form->error($model,'subcategory_id'); ?>
            </div>
        </div>
    </div>
    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'size_cat', array('class' => 'uk-form-label')); ?>
            <div class="uk-form-controls uk-form-select uk-margin-small-top before-ready-hidden">
                <?php echo $form->dropDownList(
                    $model,
                    'size_cat',
                    array('' => 'select size type'),
                    array('class' => 'js-select size-cat', 'onchange' => 'setTypeSizes(this)')
                )?>
                <?php echo $form->error($model,'size_cat'); ?>
            </div>
        </div>
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'size_type', array('class' => 'uk-form-label')); ?>
            <div class="uk-form-controls uk-form-select uk-margin-small-top before-ready-hidden">
                <?php echo $form->dropDownList($model, 'size_type', array('' => 'select size'), array('class' => 'js-select size-type'));?>
                <?php echo $form->error($model,'size_type'); ?>
                <?php echo CHtml::hiddenField('sizes' , '', array('id' => 'sizes')); ?>
            </div>
        </div>
    </div>
</div>
<div class="uk-grid">
    <div class="uk-width-1-1">
        <div class="uk-text-right uk-margin-large-top uk-margin-bottom">
            <?php echo CHtml::submitButton(Yii::t('base', 'submit'), array(
                'class' => 'uk-button'
            )); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    function setSizeType(select) {
        var url  = globals.url + '/members/size/getSizeListForSubCat';
        var data = {'category' : $(select).find('option:selected').val()};
        $.post(url, data, function(response) {
            if (!response) {return false;}
            var data   = {};
            var types  = [];
            var szType = $('.size-cat');
            $.each(szType.html(response).find('optgroup'), function() {
                var i = 0;
                var label = $(this).prop('label');
                data[label] = [];
                $(this).children().each(function() {
                    data[label][i++] = [
                        $(this).val(),
                        $(this).text()
                    ];
                });
                types.push(label);
            });
            szType.empty();
            szType.append(new Option(''));
            for (var i = 0; i < types.length; i++) {
                szType.append(new Option(types[i]));
            }
            $('#sizes').data('sizes', data);
        });
    }
    function setTypeSizes(select) {
        var cat    = $(select).find('option:selected').val();
        var sizes  = $('#sizes').data('sizes')[cat];
        var szSize = $('.size-type');
        szSize.empty();
        szSize.append(new Option(''));
        for (var i = 0; i < sizes.length; i++) {
            szSize.append(new Option(
                sizes[i][1],
                sizes[i][0]
            ));
        }
    }
    $(document).ready(function() {
        if (typeof select_init != 'undefined'){
            select_init();
            $('.before-ready-hidden').css('visibility', 'visible');
        }
        var subCat = $('.sub-cat');
        var catId  = subCat
            .find('option:selected')
            .val();
        if (catId.length) {
            setSizeType(subCat.get(0));
        }
    });
</script>
