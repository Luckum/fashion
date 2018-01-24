<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Manage Users') => array('control/users'),
    Yii::t('base', 'User Messaging') => ''
);

?>

<h1><?=Yii::t('base', 'Messaging Users'); ?> "<?php echo CHtml::encode($user->username); ?>"</h1>

<?php
if ($ratings):
    foreach ($ratings as $rating):
        if (!empty($rating->comment)):
?>
            <div>
                <h5><?= Yii::t('base', 'Comment from user') . '&nbsp;"' . CHtml::encode(isset($rating->user->username) ? $rating->user->username : '') . '"&nbsp;' . Yii::t('base', 'on product') . '&nbsp;"' . CHtml::encode(isset($rating->product->title) ? $rating->product->title : "") . '":'; ?></h5>
                <?= CHtml::encode($rating->comment); ?>
            </div>
<?php
        endif;
        if (!empty($rating->response)):
?>
            <div class="text-right">
                <h5><?= Yii::t('base', 'Response from seller') . '&nbsp;"' . CHtml::encode(isset($rating->seller->user->username) ? $rating->seller->user->username : '') . '"&nbsp;' . Yii::t('base', 'on product') . '&nbsp;"' . CHtml::encode(isset($rating->product->title) ? $rating->product->title : "") . '":'; ?></h5>
                <?= CHtml::encode($rating->response); ?>
            </div>
<?php
        endif;
    endforeach;
else:
    echo Yii::t('base', 'No comments yet');
endif;
?>