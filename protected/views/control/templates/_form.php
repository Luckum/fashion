<?php
/* @var $this TemplatesController */
/* @var $model Template */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'template-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'alias'); ?>
        <?php if($model->isNewRecord) : ?>
            <?php echo $form->dropDownList($model, 'alias', Yii::app()->params['emailAlias']); ?>
        <?php else : ?>
            <?php echo $form->textField($model, 'alias', array('size' => 60, 'maxlength' => 255, 'readonly' => !$model->isNewRecord)); ?>
        <?php endif; ?>

        <?php echo $form->error($model, 'alias'); ?>
    </div>

    <?php
    $languages = UtilsHelper::getLanguages();
    $tabs = '';
    $content = '';

    for ($i = 0; $i < count($languages); $i++) {
        $page = $model->getContentByLanguage($languages[$i]);
        if (isset($_POST['content_' . $languages[$i]])) {
            $contentPage = $_POST['content_' . $languages[$i]];
        } else {
            $contentPage = $page->content;
        }
        if (isset($_POST['subject_' . $languages[$i]])) {
            $subjectPage = $_POST['subject_' . $languages[$i]];
        } else {
            $subjectPage = $page->subject;
        }
        // $pageContent = $this->widget('application.extensions.ckeditor.CKEditor', array(
        // 	'model'=>$contentPage,
        // 	'attribute'=>'content',
        // 	'language'=>'en',
        // 	'editorTemplate'=>'full', ), true);
        $pageContent = "<textarea name=\"content_" . $languages[$i] . "\" class=\"ckeditor\">" . $contentPage . "</textarea>" .
                $form->error($model, 'content_' . $languages[$i]) .
				   "<script type=\"text/javascript\">
				      CKEDITOR.replace( 'content_+" . $languages[$i] . "' );
				      CKEDITOR.add            
				   </script>";
        $tabs .= '<li' . ($i == 0 ? ' class="active"' : '') . '><a href="#tab' . $i . '" data-toggle="tab">' . strtoupper($languages[$i]) . '</a></li>';
        $content .= '<div class="tab-pane' . ($i == 0 ? ' active' : '') . '" id="tab' . $i . '">
	<div class="row">' . $form->labelEx($page, 'content') . $pageContent . '</div>';
        $content .= '<div class="row">';
        $content .= $form->labelEx($page, 'subject');
        $content .= $form->textField(
            $model,
            'subject_' . $languages[$i],
            array(
                'name' => 'subject_' . $languages[$i],
                'value' => CHtml::encode($subjectPage)
            )
        );
        $content .= $form->error($model, 'subject_' . $languages[$i]) . '</div>';
	   $content .= '</div>';

    }
    ?>
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <?= $tabs; ?>
        </ul>
        <div class="tab-content">
            <?= $content; ?>
        </div>
        <div>
            <div>
                <label><?php echo 'Variables'; // TODO Yii::t ?></label>
            </div>
            <div class="email-vars-wrapper">
                <?php
                $variables = EmailHelper::getKeys(array(
                    new User(),
                    new Product(),
                    new SellerProfile(),
                    new Offers(),
                    new OrderItem(),
                    new Order(),
                    new Comments()
                ), array(
                    'User' => EmailHelper::$userAllowedArray,
                    'Product' => EmailHelper::$productAllowedArray,
                    'SellerProfile' => EmailHelper::$sellerAllowedArray,
                    'Offers' => EmailHelper::$offersAllowedArray,
                    'OrderItem' => EmailHelper::$orderItemAllowedArray,
                    'Order' => EmailHelper::$orderAllowedArray,
                    'Comments' => EmailHelper::$commentAllowedArray
                ),
                    EmailHelper::$additionalOptions);

                foreach ($variables as $subName => $subArray):
                    ?>
                    <div>
                        <h5 class="text-success"><?php echo $subName; ?></h5>
                    </div>

                    <?php foreach ($subArray as $key => $value): ?>
                    <div>
                        <?php echo $value; ?>
                    </div>
                <?php endforeach; ?>

                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                array('/control/templates/index') :
                //array('/control/templates/view', 'id' => $model->id)),
                array('/control/templates/index' . $backParameters)),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

    <!--DEBUG-->
    <?php //EmailHelper::example(); ?>
    <!--END DEBUG-->

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
