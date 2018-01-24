    <div class="form-actions buttons">
        <div class="offset2">
        <?php echo CHtml::submitButton('Save Changes', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link('Cancel', $this->createAbsoluteUrl('/members/profile/index'), array('class' => 'btn')); ?>
        </div>
    </div>
