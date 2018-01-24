<?php
/* @var $this DashboardController */
/* @var $products Product */
/* @var $orders Order */
/* @var $users User */

$this->breadcrumbs = array(
    Yii::t('base', 'Control Panel') => '',
);
?>

<h1><?= Yii::t('base', 'Dashboard'); ?></h1>

<?php if (Yii::app()->user->hasFlash('quickBooksFailed')): ?>
    <div class="row-fluid">
        <div class="alert alert-danger">
            <?php echo Yii::app()->user->getFlash('quickBooksFailed'); ?>
            <a href="<?php echo Yii::app()->request->baseUrl . '/control/settings/apis'; ?>"
               class="btn btn-success" style="margin-left: 20px;">
                <?php echo Yii::t('base', 'configure'); ?>
            </a>
            <a id="button-reload"
               href="<?php echo Yii::app()->request->baseUrl . '/control/index/reloadQuickBooksUsers' ?>"
               class="btn btn-success" style="margin-left: 20px;">
                <?php echo Yii::t('base', 'reload'); ?>
            </a>
        </div>
    </div>

    <!--PROGRESS-->
    <div id="quick-progress" style="margin-bottom: 20px; border: 1px solid #ccc; display: none;">
        <div id="quick-progress-inner" style="width: 0; height: 20px; background-color: #4D4984;">
        </div>
    </div>

    <script type="text/javascript">
        var server_date = '<?=date('Y-m-d H:i:s')?>';
        $('#button-reload').click(function () {

            $('#quick-progress').css('display', 'inherit');

            function quickProgressRun() {
                var width = 0;

                var interval = setInterval(step, 100);

                function step() {
                    $('#quick-progress-inner').css('width', width + '%');
                    width++;

                    if (width > 100) {
                        clearInterval(interval);
                        quickProgressRun(); // recursion
                    }
                }
            }

            quickProgressRun();
        });
    </script>
    <!--END PROGRESS-->
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('bannedwords')): ?>
    <div class="row-fluid">
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('bannedwords'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('colors')): ?>
    <div class="row-fluid">
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('colors'); ?>
        </div>
    </div>
<?php endif; ?>

<div class="text-left">
    <?php echo CHtml::link(Yii::t('base', 'Comment for moderate') . " (" . Comments::getCountComments() . ")", array('/control/settings/comments/moderate'), array('class' => 'btn btn-primary')); ?>
    <?php 
        echo CHtml::link(
            Yii::t('base', 'New products'), 
            array('/control/products?Product[status]=deactive'), 
            array('class' => 'btn btn-primary')
        );
     ?>
    <?php if (QuickbooksAuth::isExpireToken()) : ?>
        <?php echo CHtml::link(Yii::t('base', 'QuickBooks Auth Token Is Expire'), array('/control/settings/apis/getTokenQB'), array('class' => 'btn btn-danger')); ?>
    <?php endif; ?>
</div>

<div class="row">
    <div class="span4 pull-right" id="dashboardRange"
         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
        <i class="icon-calendar"></i>&nbsp;
        <span></span>
    </div>
</div>

<?php echo CHtml::hiddenField(Yii::t('base', 'from_date')); ?>
<?php echo CHtml::hiddenField(Yii::t('base', 'to_date')); ?>

<div id="grid-container">
    <?php $this->actionDateRange(); ?>
</div>
