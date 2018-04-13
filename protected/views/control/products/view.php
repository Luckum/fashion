<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Products') => array('control/products' . $backParameters),
	$model->title => '',
);
?>

<h1><?=Yii::t('base', 'View Product');?> "<?php echo CHtml::encode($model->title); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		array(
			'name' => 'category_id',
			'value' => $model->category->getNameByLanguage()->name
		),
		array(
			'label' => Yii::t('base', 'Sub Category'),
			'value' => $model->category->parent ? $model->category->parent->getNameByLanguage()->name : "Not set"
		),
		array(
			'label' => Yii::t('base', 'Attributes'),
			'type'=>'raw',
			'value' => $model->attributes() ? $model->attributes() : "Not set"
		),
		array(
			'name' => 'size_type',
			'value' => empty($model->size_chart) ? Yii :: t('base', 'No size') : $model -> size_chart -> size
		),
		array(
			'name' => 'brand_id',
			'value' => $model->brand->name
		),
		array(
			'name' => 'condition',
			'value' => $model->getConditionsName()
		),
		array(
			'name' => 'color',
			'value' => $model->color
		),
		array(
			'name' => 'description',
			'value' => $model->description
		),
		array(
			'name' => 'user_id',
			'value' => $model->user->username
		),
		array(
			'name' => 'image1',
			'type' => 'image',
			'value' => Yii::app()->request->getBaseUrl(true) . "/images/upload/" . $model->image1,
			'visible' => $model->image1 != NULL,
		),
		array(
			'name' => 'image2',
			'type' => 'image',
			'value' => Yii::app()->request->getBaseUrl(true) . "/images/upload/" . $model->image2,
			'visible' => $model->image2 != NULL,
		),
		array(
			'name' => 'image3',
			'type' => 'image',
			'value' => Yii::app()->request->getBaseUrl(true) . "/images/upload/" . $model->image3,
			'visible' => $model->image3 != NULL,
		),
		array(
			'name' => 'image4',
			'type' => 'image',
			'value' => Yii::app()->request->getBaseUrl(true) . "/images/upload/" . $model->image4,
			'visible' => $model->image4 != NULL,
		),
		array(
			'name' => 'image5',
			'type' => 'image',
			'value' => Yii::app()->request->getBaseUrl(true) . "/images/upload/" . $model->image5,
			'visible' => $model->image5 != NULL,
		),
		array(
			'name' => 'price',
			'value' => $model->price
		),
		array(
			'name' => 'comission',
			'value' => (isset($model->user->sellerProfile->comission_rate) ? $model->user->sellerProfile->comission_rate : Yii::app()->params['payment']['default_comission_rate']) * 100,
		),
		array(
			'name' => 'seller_get',
			'value' => $model->price * (1 - (isset($model->user->sellerProfile->comission_rate) ? $model->user->sellerProfile->comission_rate : Yii::app()->params['payment']['default_comission_rate'])),
		),
		array(
			'name' => 'our_selection',
			'type' => 'raw',
			'value' => CHtml::checkBox('our_selection',$model->our_selection),
		),
		array(
			'name' => 'status',
			'value' => $model->getStatusName(),
		),
		'added_date',
        array(
            'label' => Yii::t('base', 'Product Link'),
            'value' => Yii::app()->createAbsoluteUrl($model::getProductUrl($model->id))
        ),
        array(
            'label' => Yii::t('base', 'Twitter Share Link'),
            'value' => 'https://twitter.com/intent/tweet?text=' . urlencode($model->brand->name . ' ' . $model->title) . '&url=' . Yii::app()->createAbsoluteUrl($model::getProductUrl($model->id, $model)) . '&hashtags=n2315.com'
        )
	),
)); ?>

<div class="form-actions">
    <p class="pull-left">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/products/index' . $backParameters), array('class' => 'mr100 btn btn-primary')); ?>
        <?php if ($model -> status == Product :: PRODUCT_STATUS_DEACTIVE || $model -> status == Product :: PRODUCT_STATUS_PENDING): ?>
            <?php echo CHtml::link(Yii::t('base', 'Accept'), 'javascript:void(0)', array('data-status' => Product :: PRODUCT_STATUS_ACTIVE, 'class' => 'btn btn-primary btn-change-status')); ?>
        <?php endif; ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/products/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php if ($model -> status == Product :: PRODUCT_STATUS_DEACTIVE || $model -> status == Product :: PRODUCT_STATUS_PENDING): ?>
            <?php echo CHtml::link(Yii::t('base', 'Decline'), 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => "if(confirm('" . Yii::t('base', 'Do you really want to do this action?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/products/delete', array('id' => $model->id))."';")); ?>
        <?php endif; ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('" . Yii::t('base', 'Are you sure you want to delete this item?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/products/delete', array('id' => $model->id))."';")); ?>
    </p>
    <?php if ($model -> status == Product :: PRODUCT_STATUS_DEACTIVE): ?>
        <p class="pull-right">
            <?php echo CHtml::link(Yii::t('base', 'Request for change'), array('#'), array('data-status' => Product :: PRODUCT_STATUS_PENDING, 'class' => 'rfc-btn btn btn-primary btn-change-status')); ?>
            <span id="l_container">
                <?=CHtml::dropDownList('pAttrs', '', $model -> attributeLabels(), array('id' => 'pAttrs', 'multiple' => 'multiple'))?>
            </span>
        </p>
    <?php endif; ?>
</div>

<!--Bootstrap Multiselect-->
<?php Yii :: app()
    -> clientScript
    -> registerScriptFile('/js/bootstrap-multiselect.js', CClientScript :: POS_END)
    -> registerCssFile('/css/bootstrap-multiselect.css')
?>
<script>
    $(document).ready(function() {
        /**
         * Изменение статуса продукта.
         */
        $('.btn-change-status').on('click', function(event) {
            event.preventDefault();
            if ($(this).hasClass('rfc-btn')) {
                // Нажали на кнопку 'Request for change'.
                var attrs = [];
                var l_container = $('#l_container');
                if (l_container.is(':visible')) {
					var items = l_container.find('option:selected');
                    items.each(function() {
                        attrs.push($(this).val());
                    });
                    if (!attrs.length) {
                        alert('<?=Yii::t('base', 'You did not select any attribute!')?>');
                    }
                    $(this).text('<?=Yii::t('base', 'Request for change')?>');
                    l_container.hide();
                } else {
                    $(this).text('<?=Yii::t('base', 'Inform user about the wrong attributes')?>');
                    l_container.show();
                }
                if (!attrs.length) {
                    return false;
                }
            }
            if (!confirm('<?=Yii::t('base', 'Do you really want to do this action?')?>')) {
                return false;
            }
            var url  = globals.url + '/control/products/setStatusForProduct';
            var data = {
                'id'    : <?=$model->id?>,
                'status': $(this).data('status'),
                'extra' : typeof attrs != 'undefined' ? attrs.join(',') : ''
            };
            $.post(url, data, function () {
                location.reload();
            });
        });
		$('#our_selection').change(function(e) {
			var url  = globals.url + '/control/products/setOurChoice';
			var value=0;
			if($(this).is(':checked')) value = 1;
			else value = 0;
			var data = {
				'id'    : <?=$model->id?>,
				'value': value,
			};
			$.post(url, data, function () {
				location.reload();
			});
		});
        /**
         * Инициализация multiselect.
         */
        $('#pAttrs').multiselect({
            'onChange' : function(option, checked) {
            }
        });
    });
</script>
