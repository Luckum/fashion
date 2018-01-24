<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/js/uikit.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/js/assets.min.js"></script>

<div class="offset3 span6 pull-left">
    <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom"><?=Yii::t('base', 'Feedback')?></div>
</div>
    <?php echo CHtml::beginForm(); ?>
    <?=CHtml::hiddenField('product_id', $id )?>
<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-2 uk-push-1-5">
    <div><b><?php echo Yii::t('base', 'Quick to respond'); ?>:</b></div>
    <div><b><input type="hidden" class="rating-communication" name="communication" data-filled="uk-icon-star" data-empty="uk-icon-star-o"
                   data-fractions="1" value="0"></b></div>
</div>

<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-2 uk-push-1-5">
    <div><b><?php echo Yii::t('base', 'Item as described'); ?>:</b></div>
    <div><b><input type="hidden" class="rating-description" name="description" data-filled="uk-icon-star" data-empty="uk-icon-star-o"
                   data-fractions="1" value="0"></b></div>
</div>
<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-2 uk-push-1-5">
    <div><b><?php echo Yii::t('base', 'Ships within 48 hours'); ?>:</b></div>
    <div><b><input type="hidden" class="rating-shipment" name="shipment" data-filled="uk-icon-star" data-empty="uk-icon-star-o"
           data-fractions="1" value="0"></b></div>
</div>

<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-2 uk-push-1-5">
    <div><b></b></div>
    <div><b><?php echo CHtml::button(Yii::t('base', 'submit'), array('class'=>'uk-button uk-button add_review')); ?></b></div>
</div>

<?php echo CHtml::endForm(); ?>
