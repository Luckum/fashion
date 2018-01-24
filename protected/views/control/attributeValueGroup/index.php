<?php
/* @var $this AttributeValueGroupController */
/* @var $model AttributeValueGroup */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Attribute defined values') => array('control/attributeValue'),
    Yii::t('base', 'Groups for defined values')
);

?>

<h1><?=Yii::t('base', 'Groups for defined values');?></h1>

<div class="text-right">
    <?php
    echo CHtml::link(Yii::t('base', 'Add group'), array('control/attributeValueGroup/create'), array('class' => 'btn btn-primary'));     
?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'attribute-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true, 
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/attributeValueGroup/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        'id',
        'value',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'deleteConfirmation' => Yii::t('base', 'Are you sure you want to delete this group?'),
            'htmlOptions' => array('width' => '10%'),
        ),
    ),
)); ?>
