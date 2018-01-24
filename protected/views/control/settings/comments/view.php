<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Comments Settings - Moderate Comments') => array('control/settings/comments/moderate'),
    Yii::t('base', 'View comments') => ''
);

?>

<?php if ($model->comment_status == 'banned' && $model->response_status == 'banned'): ?>
    <h4><?= Yii::t('base', 'View Banned Messages Between User') . '&nbsp;"' .  CHtml::encode($model->user->username) . '"&nbsp;' . Yii::t('base', 'And Seller') . '&nbsp;"' . CHtml::encode($model->product->user->username) . '"'; ?></h4>
    <div class="row-fluid">
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array('name' => 'product', 'value' => $model->product->title),
                array('name' => 'user_id', 'value' => $model->user->username),
                array('name' => 'seller_id', 'value' => $model->product->user->username),
                'comment',
                'response'
            ),
        )); ?>
    </div>
    <div class="form-actions">
            <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/settings/comments/moderate'), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Edit Comment'), array('/control/settings/comments/update', 'id' => $model->id, 'type' => 'c'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Edit Response'), array('/control/settings/comments/update', 'id' => $model->id, 'type' => 'r'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Publish Comment'), array('/control/settings/comments/publish', 'id' => $model->id, 'type' => 'c'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Publish Response'), array('/control/settings/comments/publish', 'id' => $model->id, 'type' => 'r'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Delete Comment'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this comment?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/settings/comments/delete', array('id' => $model->id, 'type' => 'c'))."';")); ?>
            <?php echo CHtml::link(Yii::t('base', 'Delete Response'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this response?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/settings/comments/delete', array('id' => $model->id, 'type' => 'r'))."';")); ?>
    </div>
<?php else: ?>
    <?php
        $title = ($model->comment_status == 'banned') ? 
            Yii::t('base', 'View Banned Comment From User') :
            Yii::t('base', 'View Comment From User');

        $title .= '&nbsp;"' .  CHtml::encode($model->user->username) . '"&nbsp;' . Yii::t('base', 'To Seller') . '&nbsp;"' . CHtml::encode($model->product->user->username) . '"';
    ?>
    <h4><?= $title ?></h4>

    <div class="row-fluid">
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array('name' => 'product', 'value' => $model->product->title),
                array('name' => 'user_id', 'value' => $model->user->username),
                array('name' => 'seller_id', 'value' => $model->product->user->username),
                'comment',
            ),
        )); ?>
    </div>
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/settings/comments/moderate'), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Edit Comment'), array('/control/settings/comments/update', 'id' => $model->id, 'type' => 'c'), array('class' => 'btn btn-success')); ?>
            <?php if ($model->comment_status == 'banned'): ?>
                <?php echo CHtml::link(Yii::t('base', 'Publish Comment'), array('/control/settings/comments/publish', 'id' => $model->id, 'type' => 'c'), array('class' => 'btn btn-success')); ?>
            <?php else: ?>
                <?php echo CHtml::link(Yii::t('base', 'Ban Comment'), array('/control/settings/comments/ban', 'id' => $model->id, 'type' => 'c'), array('class' => 'btn btn-success')); ?>
            <?php endif; ?>
            <?php echo CHtml::link(Yii::t('base', 'Delete Comment'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this comment?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/settings/comments/delete', array('id' => $model->id, 'type' => 'c'))."';")); ?>
        </div>
    </div>   
    <?php if (!empty($model->response)): ?>
        <br /><br /> <hr />
        <?php
            $title = ($model->response_status == 'banned') ? 
                Yii::t('base', 'View Banned Response From Seller') :
                Yii::t('base', 'View Response From Seller');

            $title .= '&nbsp;"' .  CHtml::encode($model->product->user->username) . '"&nbsp;' . Yii::t('base', 'To User') . '&nbsp;"' . CHtml::encode($model->user->username) . '"';
        ?>
        <h4><?= $title ?></h4>

        <div class="row-fluid">
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>array(
                    array('name' => 'product', 'value' => $model->product->title),
                    array('name' => 'seller_id', 'value' => $model->product->user->username),
                    array('name' => 'user_id', 'value' => $model->user->username),
                    'response',
                ),
            )); ?>
        </div>
        <div class="form-actions">
            <div class="offset2">
                <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/settings/comments/moderate'), array('class' => 'btn btn-primary')); ?>
                <?php echo CHtml::link(Yii::t('base', 'Edit Response'), array('/control/settings/comments/update', 'id' => $model->id, 'type' => 'r'), array('class' => 'btn btn-success')); ?>
                <?php if ($model->response_status == 'banned'): ?>
                    <?php echo CHtml::link(Yii::t('base', 'Publish Response'), array('/control/settings/comments/publish', 'id' => $model->id, 'type' => 'r'), array('class' => 'btn btn-success')); ?>
                <?php else: ?>
                    <?php echo CHtml::link(Yii::t('base', 'Ban Response'), array('/control/settings/comments/ban', 'id' => $model->id, 'type' => 'r'), array('class' => 'btn btn-success')); ?>
                <?php endif; ?>
                <?php echo CHtml::link(Yii::t('base', 'Delete Response'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this response?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/settings/comments/delete', array('id' => $model->id, 'type' => 'r'))."';")); ?>
            </div>
        </div>
    <?php endif ?>
<?php endif; ?>
