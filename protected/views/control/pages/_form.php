<?php
/* @var $this PagesController */
/* @var $model Pages */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'page_title'); ?>
		<?php echo $form->textField($model,'page_title',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'page_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->dropDownList($model,'position', $model->getPositions(), array('id'=>'position-drop')); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

<?php
$languages = UtilsHelper::getLanguages();
$tabs = '';
$content = '';

for($i = 0; $i < count($languages); $i++) {
	$contentPage = $model->getContentByLanguage($languages[$i]);
	// $pageContent = $this->widget('application.extensions.ckeditor.CKEditor', array( 
	// 	'model'=>$contentPage, 
	// 	'attribute'=>'content', 
	// 	'language'=>'en', 
	// 	'editorTemplate'=>'full', ), true);
	$pageContent = "<textarea name=\"content_".$languages[$i]."\" class=\"ckeditor\">".$contentPage->content."</textarea>" .
			$form->error($model, 'content_' . $languages[$i]) .
				   "<script type=\"text/javascript\">
				      CKEDITOR.replace( 'content_+".$languages[$i]."' );
				      CKEDITOR.add            
				   </script>";
	$tabs .= '<li' .($i == 0 ? ' class="active"' : '') . '><a href="#tab'.$i.'" data-toggle="tab">'.strtoupper($languages[$i]).'</a></li>';
	$content .= '<div class="tab-pane'. ($i == 0 ? ' active' : '') .'" id="tab'.$i.'">
	<div class="row">' . $form->labelEx($contentPage,'content') . $pageContent . '</div>
	<div class="row">' . $form->labelEx($contentPage,'title') . '<input type="text" name="title_'.$languages[$i].'" value="' . CHtml::encode($contentPage->title) . '">' . '</div>
	<div class="row">' . $form->labelEx($contentPage,'seo_description') . '<textarea name="seo_description_'. $languages[$i] .'">' . CHtml::encode($contentPage->seo_description) . ' </textarea>' . '</div>
	<div class="row">' . $form->labelEx($contentPage,'seo_keywords') . '<textarea name="seo_keywords_'. $languages[$i] .'">' . CHtml::encode($contentPage->seo_keywords) . ' </textarea>' . '</div> 
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
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', $model->getStatuses()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row" id="menu-order">
		<?php echo $form->labelEx($model,'menu_order'); ?>
		<?php echo $form->dropDownList($model,'menu_order', $model->getMenuOrders()); ?>
		<small><?=Yii::t('base', '"0" (Zero) means page is not visible in website menu');?></small>
		<?php echo $form->error($model,'menu_order'); ?>
	</div>

	<div class="row" id="footer-order">
		<?php echo $form->labelEx($model,'footer_order'); ?>
		<?php echo $form->dropDownList($model,'footer_order', $model->getFooterOrders()); ?>
		<small><?=Yii::t('base', '"0" (Zero) means page is not visible in website footer menu');?></small>
		<?php echo $form->error($model,'footer_order'); ?>
	</div>

	<div class="form-actions">
		<div class="offset2">
			<?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
				array('/control/pages/index') :
				//array('/control/pages/view', 'id' => $model->id)),
				array('/control/pages/index' . $backParameters)),
				array('class' => 'btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#menu-order').hide();
		$('#position-drop').change(function () {
			if ($('#position-drop').val() == <?=Page::POSITION_FOOTER?>) {
				$('#footer-order').show();
				$('#menu-order').hide();
			} else if($('#position-drop').val() == <?=Page::POSITION_MENU?>) {
				$('#footer-order').hide();
				$('#menu-order').show();
			} else if($('#position-drop').val() == <?=Page::POSITION_FOOTER_AND_MENU?>) {
				$('#footer-order').show();
				$('#menu-order').show();
			}
		});
	});
</script>
<?php Yii::app()->clientScript->registerScriptFile('/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>

