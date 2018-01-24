<?php
/* @var $this AttributesController */
/* @var $model Attribute */
/* @var $form CActiveForm */

CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attribute-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
//        'accept-charset' => 'utf-8',
    ),
    
)); ?>

<?php 
    $languages = UtilsHelper::getLanguages();
    $tabs = '';
    $contentName = '';
    $contentTextfieldValues = '';
    $contentValuesTextarea = '';
    $contentValuesDropdown = '';
    $tabsValues = $tabsNames = $tabsTextArea = $tabsDropDown = '';

    for($i = 0; $i < count($languages); $i++) {
        $name = $model->getNameByLanguage($languages[$i]);
        if (isset($_POST['name_'.$languages[$i]])) {
            $attrName = $_POST['name_'.$languages[$i]];
        } else {
            $attrName = $name->name;
        }
        
        if (isset($_POST['values_'.$languages[$i]])) {
            if (is_array($_POST['values_'.$languages[$i]])) {
                $attrValues = implode(',', $_POST['values_'.$languages[$i]]);
            } else {
                $attrValues = $_POST['values_'.$languages[$i]];
            }
        } else {
            $attrValues = $name->values;
        }

        $tabsNames .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'_names" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';
        $tabsValues .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'_values" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';
        $tabsTextArea .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'_textarea" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';
        $tabsDropDown .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'_dropdown" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';

        $contentName .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'_names">
        <div class="row">' . $form->labelEx($name,'name') . '<input type="text" name="name_'.$languages[$i].'" value="' . CHtml::encode($attrName) . '">' . '</div>
        </div>';

        $contentTextfieldValues .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'_values">
        <div class="row attr_values">' . $form->labelEx($name,'values') . 
            '<input type="text" name="values_'.$languages[$i].'" value="'.CHtml::encode($attrValues).'" />' . '<br/></div>
        </div>';

        $contentValuesTextarea .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'_textarea">
        <div class="row textarea_values">' . $form->labelEx($name,'values') . "<textarea name=\"values_".$languages[$i]."\" class=\"ckeditor\">".$attrValues."</textarea>
                   <script type=\"text/javascript\">
                      CKEDITOR.replace( 'values_+".$languages[$i]."' );
                      CKEDITOR.add            
                   </script>" . '</div>
        </div>';

        $contentValuesDropdown .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'_dropdown">
        <div class="row dropdown_values">' . $form->labelEx($name,'values');

        $values = AttributeValue::getValuesWithGroupsList($languages[$i]);
        $definedValueGroups = AttributeValueGroup::getGroups();

        $checkedValues = explode(',', $attrValues);

        $selectedGroup = '';
        foreach ($values as $value) {
            if (in_array($value['value'], $checkedValues)) {
                $selectedGroup = $value['group_id'];
                break;
            }
        }
        
        if (empty($values)) {
            $contentValuesDropdown .= Yii::t('base', 'Create at least one defined value for this language') . '&nbsp;';
            $contentValuesDropdown .= CHtml::link(Yii::t('base', 'Create it!'), array('/control/attributeValue/create'), array('class' => 'btn btn-primary'));
        } else {
            $contentValuesDropdown .= "Groups&nbsp;";
            $contentValuesDropdown .= CHtml::dropDownList(
                'group_ids',
                $selectedGroup,
                $definedValueGroups, 
                array(
                    'onchange' => 'toogleDefinedValues(this)',
                    'data-lang' => $languages[$i],
                )
            ) . "<br/>";
        }

        foreach ($values as $value) {
            $checked = (in_array($value['value'], $checkedValues)) ? 'checked="checked"' : '';
            $displayStyle = '';
            if ($selectedGroup != $value['group_id']) {
                $displayStyle = 'style="display:none"';
            }
            $contentValuesDropdown .= '<div data-lang="' . $languages[$i] . '" '. $displayStyle .' data-group-id="' . CHtml::encode($value['group_id']) . '"><input '.$checked.' type="checkbox" name="values_'.$languages[$i].'[]" value="' . $value['value'] . '" />' . CHtml::encode($value['value']) . '</div>';
        }
        
        $contentValuesDropdown .= '<br/></div>
        </div>';
    }
 ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<label for="<?= get_class($model) . '[categories][]' ?>"><?= Yii::t('base', 'Categories') ?></label>
        <?php   echo CHtml::dropDownList(
                    get_class($model) . '[categories][]',
                    CHtml::listData($model->categories, 'id', 'id'),
                    Category::getFullListForDropDown(),
                    array('multiple' => 'multiple', 'id' => 'categories_multi_select'));
        ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php 
            $listOptions = array();
            if (!$model->isNewRecord) {
                $listOptions['disabled'] = 'disabled';
            }
            echo $form->dropDownList(
                $model,
                'type',
                $model->getTypes(),
                $listOptions
            ); 
        ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

    <div class="tabbable"> 
        <ul class="nav nav-tabs"><?=$tabsNames;?></ul>
        <div class="tab-content"><?=$contentName;?></div>
    </div>

    <div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

    <div class="tabbable"> 
        <ul class="nav nav-tabs"><?=$tabsTextArea;?></ul>
        <div class="tab-content"><?=$contentValuesTextarea;?></div>
    </div>
    <div class="tabbable"> 
        <ul class="nav nav-tabs"><?=$tabsDropDown;?></ul>
        <div class="tab-content"><?=$contentValuesDropdown;?></div>
    </div>

    <div class="tabbable"> 
        <ul class="nav nav-tabs"><?=$tabsValues;?></ul>
        <div class="tab-content"><?=$contentTextfieldValues;?></div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'required'); ?>
		<?php echo $form->dropDownList($model,'required', array('yes' => Yii::t('base', 'yes'), 'no' => Yii::t('base', 'no'))); ?>
		<?php echo $form->error($model,'required'); ?>
	</div>

	<div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status', $model->getStatuses()); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                array('/control/attributes/index') :
                //array('/control/attributes/view', 'id' => $model->id)),
                array('/control/attributes/index' . $backParameters)),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
<!--Bootstrap Multiselect-->
<?php Yii :: app()
    -> clientScript
    -> registerScriptFile('/js/bootstrap-multiselect.js', CClientScript :: POS_END)
    -> registerCssFile('/css/bootstrap-multiselect.css')
?>
<script language="JavaScript">
$().ready(function(){
    $('#categories_multi_select').multiselect();
    showValues();
    $('#Attribute_type').on('change', function(){showValues()});
});

function showValues() {
    var type = $('#Attribute_type').val();
    
    hideElements('.attr_values');
    hideElements('.textarea_values');
    hideElements('.dropdown_values');
    switch(type) {
        case 'dropdown':
        case 'checkbox':
            showElements('.dropdown_values');
            break;
        case 'textarea':
            showElements('.textarea_values');
            break;
        default:
            showElements('.attr_values');
    }
}

function showElements(cl) {
    $(cl).parents('.tabbable').show();
    $(cl).find('input, select').prop( "disabled", false );
    CKEDITOR.config.readOnly = false;
}

function hideElements(cl) {
    $(cl).parents('.tabbable').hide();
    $(cl).find('input, select').prop( "disabled", true );
    CKEDITOR.config.readOnly = true;
}

function toogleDefinedValues(el){
    var list = $(el).val();
    var lang = $(el).attr('data-lang');
    $("*[data-group-id][data-lang='" + lang + "']").hide();
    $("*[data-group-id='" + list + "'][data-lang='" + lang + "']").show();
}
</script>
</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile('/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>