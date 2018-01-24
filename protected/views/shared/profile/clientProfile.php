<div class="row">
    <div class="span6">
        <div class="row">
            <?php echo $form->labelEx($model,'firstname'); ?>
            <?php echo $form->textField($model,'firstname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'lastname'); ?>
            <?php echo $form->textField($model,'lastname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'companyname'); ?>
            <?php echo $form->textField($model,'companyname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
        </div>
        
        <div class="row"><br><br></div>            
    </div>

    <div class="span5">

        <div class="row">
            <?php echo $form->labelEx($model,'address1'); ?>
            <?php echo $form->textField($model,'address1'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'address2'); ?>
            <?php echo $form->textField($model,'address2'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'city'); ?>
            <?php echo $form->textField($model,'city'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'state'); ?>
            <?php echo CHtml::textField('state', $model->state);//$form->textField($model,'state'); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'postcode'); ?>
            <?php echo $form->textField($model,'postcode'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'country'); ?>
            <?php echo CHtml::dropDownList('country', $model->country, Yii::app()->params['countries']);//$form->dropDownList($model,'country', Yii::app()->params['countries']); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'phonenumber'); ?>
            <?php echo $form->textField($model,'phonenumber'); ?>
        </div>
    
    </div>
</div>