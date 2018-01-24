<?php
/* @var $this CategoriesController */
/* @var $model Category */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php //if(!Category::model()->getExternalSaleCategoryId()) { ?>
	<div class="row">
        <?php echo $form->labelEx($model,'external_sale'); ?>
        <?php echo $form->checkBox($model, 'external_sale'); ?>
        <?php echo $form->error($model,'external_sale'); ?>
    </div>
    <?php //}?>
	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id', $model->getParents()); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'size_chart_cat_id'); ?>
        <?php echo $form->dropDownList($model, 'size_chart_cat_id', CHtml::listData(SizeChartCat::model()->findAll(), 'id', 'name'), array('empty'=>'No Size Category')); ?>
        <?php echo $form->error($model, 'size_chart_cat_id'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', $model->getStatuses()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	
	<div class="row"><!-- 
		<?php echo $form->labelEx($model,'menu_order'); ?>
		<?php echo $form->textField($model,'menu_order', array('readOnly'=>true)); ?>
		<small><?=Yii::t('base', '"0" (Zero) means category is not visible in website top menu');?></small>
		<?php echo $form->error($model,'menu_order'); ?>
	</div> -->
	
<?php
$languages = UtilsHelper::getLanguages();
$tabs = '';
$content = '';
for($i = 0; $i < count($languages); $i++) {
	$name = $model->getNameByLanguage($languages[$i]);
	if (isset($_POST['name_'.$languages[$i]])) {
		$catName = $_POST['name_'.$languages[$i]];
	} else {
		$catName = $name->name;
	}
	if (isset($_POST['header_text_' . $languages[$i]])){
		$header_text = $_POST['header_text_' . $languages[$i]];
	} else {
		$header_text = $name->header_text;
	}
	if (isset($_POST['seo_title_'.$languages[$i]])) {
		$catSeoTitle = $_POST['seo_title_'.$languages[$i]];
	} else {
		$catSeoTitle = $name->seo_title;
	}
	if (isset($_POST['seo_description_'.$languages[$i]])) {
		$catSeoDesc = $_POST['seo_description_'.$languages[$i]];
	} else {
		$catSeoDesc = $name->seo_description;
	}
	if (isset($_POST['seo_keywords_'.$languages[$i]])) {
		$catSeoKey = $_POST['seo_keywords_'.$languages[$i]];
	} else {
		$catSeoKey = $name->seo_keywords;
	}
	$tabs .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';
	$content .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'">
	<div class="row">';
	$content .= $form->labelEx($name,'name');
	$content .= $form->textField(
		$model,
		'name_' . $languages[$i],
		array(
			'name' => 'name_' . $languages[$i],
			'value' => $catName
		)
	);
	$content .= $form->error($model, 'name_'.$languages[$i]) . '</div>';

	$content .= '<div class="row">';
	$content .= $form->labelEx($name,'header_text');
	$content .= $form->textField(
		$model,
		'header_text_'.$languages[$i],
		array(
			'name' => 'header_text_'.$languages[$i],
			'value' => $header_text
		)
	);
	$content .= $form->error($model, 'header_text_'.$languages[$i]) . '</div>';

	$content .= '<div class="row">';
	$content .= $form->labelEx($name,'seo_title');
	$content .= $form->textField(
		$model,
		'seo_title_'.$languages[$i],
		array(
			'name' => 'seo_title_'.$languages[$i],
			'value' => $catSeoTitle
		)
	);
	$content .= $form->error($model, 'seo_description_' . $languages[$i]) . '</div>';

	$content .= '<div class="row">';
	$content .= $form->labelEx($name, 'seo_description');
	$content .= $form->textArea(
		$model,
		'seo_description'.$languages[$i],
		array(
			'name' => 'seo_description_' . $languages[$i],
			'value' => $catSeoDesc
		)
	);
	$content .= $form->error($model, 'seo_description_' . $languages[$i]) . '</div>';

	$content .= '<div class="row">';
	$content .= $form->labelEx($name, 'seo_keywords');
	$content .= $form->textArea(
		$model,
		'seo_keywords_' . $languages[$i],
		array(
			'name' => 'seo_keywords_' . $languages[$i],
			'value' => $catSeoKey
		)
	);
	$content .= $form->error($model, 'seo_keywords_' . $languages[$i]) . '</div>';
	
	$content .= '</div>';
}
?>

	 <div class="tabbable"> 
      <ul class="nav nav-tabs"><?=$tabs;?>
      </ul>
      <div class="tab-content"><?=$content;?></div>
    </div>	

	<div class="form-actions">
		<div class="offset2">
			<?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
				array('/control/categories/index') :
				//array('/control/categories/view', 'id' => $model->id)),
				array('/control/categories/index' . $backParameters)),
				array('class' => 'btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script language="JavaScript">
var newRec = <?=$model->isNewRecord ? '1' : '0';?>;
var curOrd = <?=intval($model->menu_order);?>;
</script>
<?php Yii::app()->clientScript->registerScriptFile('/js/categoryorder.js', CClientScript::POS_END); ?>