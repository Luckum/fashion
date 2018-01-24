<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Users') => array('control/users' . $backParameters),
    $model->username => '',
);

?>

<h1><?=Yii::t('base', 'View User'); ?> "<?php echo CHtml::encode($model->username); ?>"</h1>

<div class="row-fluid">
    <div class="span9">
        <?php $this->widget('zii.widgets.CDetailView', array(
	        'data'=>$model,
	        'attributes'=>array(
		        'id',
		        'username',
		        'email',
		        'registration_date',
		        'last_login',
		        array('name' => $model->getAttributeLabel('country_id'), 'value' => $model->country->name),
                array('name' => $model->getAttributeLabel('status'), 'value' => $model->getStatusNameByStatus()),
                array('name' => $model->getAttributeLabel('type'), 'value' => $model->getTypeName()),
	        ),
        )); ?>

        <?php
        if ($sellerModel) {
            $this->widget('zii.widgets.CDetailView', array(
                'data'=>$sellerModel,
                'attributes'=>array(
                    'seller_type',
                    array('name' => 'comission_rate', 'value' => $sellerModel->comission_rate * 100),
                    'paypal_email',
                    'rating',
                ),
            ));
        }
        ?>
    </div>
    <div class="span3">
        <div id="stat_div">
            <?php 
            if ($sellerModel) : ?>
            <?php
                $total = OrderItem::model()->getTotalByUser($model->id);
                echo Yii::t('base', 'Total Revenue') . ':&nbsp;' . round($total, 2) . '&nbsp;EUR'; ?>
                </div>
                <input type="hidden" id="user_id" value="<?= $model->id; ?>">
                <input type="hidden" id="user_type" value="<?=User::SELLER; ?>">
                <select name="date_filter" id="date_filter">
                <option value="0"><?= Yii::t('base', 'All Time'); ?></option>
                <option value="1"><?= Yii::t('base', 'Last 24 hours'); ?></option>
                <option value="2"><?= Yii::t('base', 'Last 7 days'); ?></option>
                <option value="3"><?= Yii::t('base', 'Current month'); ?></option>
                <option value="4"><?= Yii::t('base', 'Range'); ?></option>
                </select>
                <div id="date_filter_range" style="display: none;">
                    <?= Yii::t('base', 'Start Date'); ?>
                    <div class="input-append date" id="dp_users_start" >
                        <input class="span6" type="text" readonly="readonly">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <?= Yii::t('base', 'End Date'); ?>
                    <div class="input-append date" id="dp_users_end" >
                        <input class="span6" type="text" readonly="readonly">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <a href="javascript:void(0)" onclick="getFilteredData();" class="btn">
                        <?= Yii::t('base', 'Send'); ?>
                    </a>
                </div><br/>
            <?php endif; ?>
        <div id="stat_div_buyer">
            <?php
                $total = Order::model()->getTotalByUser($model->id);
                echo Yii::t('base', 'Total Expense') . ':&nbsp;' . round($total, 2) . '&nbsp;EUR'; ?>
        </div>
                <input type="hidden" id="user_id_buyer" value="<?= $model->id; ?>">
                <input type="hidden" id="user_type_buyer" value="<?=User::BUYER; ?>">
                <select name="date_filter_buyer" id="date_filter_buyer">
                    <option value="0"><?= Yii::t('base', 'All Time'); ?></option>
                    <option value="1"><?= Yii::t('base', 'Last 24 hours'); ?></option>
                    <option value="2"><?= Yii::t('base', 'Last 7 days'); ?></option>
                    <option value="3"><?= Yii::t('base', 'Current month'); ?></option>
                    <option value="4"><?= Yii::t('base', 'Range'); ?></option>
                </select>
                <div id="date_filter_range_buyer" style="display: none;">
                    <?= Yii::t('base', 'Start Date'); ?>
                    <div class="input-append date" id="dp_users_start_buyer" >
                        <input class="span6" type="text" readonly="readonly">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <?= Yii::t('base', 'End Date'); ?>
                    <div class="input-append date" id="dp_users_end_buyer" >
                        <input class="span6" type="text" readonly="readonly">
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <a href="javascript:void(0)" onclick="getFilteredDataBuyer();" class="btn">
                        <?= Yii::t('base', 'Send'); ?>
                    </a>
                </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/users/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/users/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php 
            if ($model->status == User::ACTIVE) {
                echo CHtml::link(Yii::t('base', 'Block User'), array('/control/users/changeStatus', 'id' => $model->id, 'status' => User::BLOCKED), array('class' => 'btn'));
            } else {
                echo CHtml::link(Yii::t('base', 'Activate User'), array('/control/users/changeStatus', 'id' => $model->id, 'status' => User::ACTIVE), array('class' => 'btn'));
            }
        ?>
        <?php
            if ($model->sellerProfile !== null) {
                echo CHtml::link(Yii::t('base', 'View Products'), array('/control/products/index', 'userid' => $model->id), array('class' => 'btn'));
            }
            echo CHtml::link(Yii::t('base', 'View Orders'), array('/control/orders/index', 'userid' => $model->id), array('class' => 'btn'));
            echo CHtml::link(Yii::t('base', 'View User Comments'), array('/control/settings/comments/view', 'userid' => $model->id), array('class' => 'btn'));
            echo CHtml::link(Yii::t('base', 'View More User Details'), array('/control/users/more', 'id' => $model->id), array('class' => 'btn'));
        ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this item?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/users/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#date_filter").change(function() {
            if ($(this).val() == 4) {
                $('#date_filter_range').show();
            } else {
                $('#date_filter_range').hide();
                var html = $.ajax({
                    url: "<?= Yii::app()->urlManager->createUrl("/control/users/ajaxGetDataByDate"); ?>",
                    async: false,
                    type: "POST",
                    data: {filter: $(this).val(), userId: $('#user_id').val(), userType: $('#user_type').val()}
                }).responseText;
                $("#stat_div").html(html);
            }
            
        });
        $("#date_filter_buyer").change(function() {
            if ($(this).val() == 4) {
                $('#date_filter_range_buyer').show();
            } else {
                $('#date_filter_range_buyer').hide();
                var html = $.ajax({
                    url: "<?= Yii::app()->urlManager->createUrl("/control/users/ajaxGetDataByDate"); ?>",
                    async: false,
                    type: "POST",
                    data: {filter: $(this).val(), userId: $('#user_id_buyer').val(), userType: $('#user_type_buyer').val()}
                }).responseText;
                $("#stat_div_buyer").html(html);
            }

        });
        $("#dp_users_start").datepicker({format: "yyyy-mm-dd"}).on("changeDate", function(ev){
            var dateText = $(this).data("date");
            var endDateTextBox = $("#dp_users_end input");
            if (endDateTextBox.val() != "") {
                var testStartDate = new Date(dateText);
                var testEndDate = new Date(endDateTextBox.val());
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(dateText);
                }
            } else {
                endDateTextBox.val(dateText);
            };
            $("#dp_users_end").datepicker("setStartDate", dateText);
            $("#dp_users_start").datepicker("hide");
        });
        $("#dp_users_end").datepicker({format: "yyyy-mm-dd"}).on("changeDate", function(ev){
            var dateText = $(this).data("date");
            var startDateTextBox = $("#dp_users_start input");
            if (startDateTextBox.val() != "") {
                var testStartDate = new Date(startDateTextBox.val());
                var testEndDate = new Date(dateText);
                if (testStartDate > testEndDate) {
                    startDateTextBox.val(dateText);
                }
            } else {
                startDateTextBox.val(dateText);
            };
            $("#dp_users_start").datepicker("setEndDate", dateText);
            $("#dp_users_end").datepicker("hide");
        });
        $("#dp_users_start_buyer").datepicker({format: "yyyy-mm-dd"}).on("changeDate", function(ev){
            var dateText = $(this).data("date");
            var endDateTextBox = $("#dp_users_end_buyer input");
            if (endDateTextBox.val() != "") {
                var testStartDate = new Date(dateText);
                var testEndDate = new Date(endDateTextBox.val());
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(dateText);
                }
            } else {
                endDateTextBox.val(dateText);
            };
            $("#dp_users_end_buyer").datepicker("setStartDate", dateText);
            $("#dp_users_start_buyer").datepicker("hide");
        });
        $("#dp_users_end_buyer").datepicker({format: "yyyy-mm-dd"}).on("changeDate", function(ev){
            var dateText = $(this).data("date");
            var startDateTextBox = $("#dp_users_start_buyer input");
            if (startDateTextBox.val() != "") {
                var testStartDate = new Date(startDateTextBox.val());
                var testEndDate = new Date(dateText);
                if (testStartDate > testEndDate) {
                    startDateTextBox.val(dateText);
                }
            } else {
                startDateTextBox.val(dateText);
            };
            $("#dp_users_start_buyer").datepicker("setEndDate", dateText);
            $("#dp_users_end_buyer").datepicker("hide");
        });
    });
    function getFilteredData()
    {
        var html = $.ajax({
            url: "<?= Yii::app()->urlManager->createUrl("/control/users/ajaxGetDataByDate"); ?>",
            async: false,
            type: "POST",
            data: {filter: 4, userId: $('#user_id').val(), userType: $('#user_type').val(), start_date: $('#dp_users_start input').val(), end_date: $('#dp_users_end input').val()}
        }).responseText;
        $("#stat_div").html(html);
    }
    function getFilteredDataBuyer()
    {
        var html = $.ajax({
            url: "<?= Yii::app()->urlManager->createUrl("/control/users/ajaxGetDataByDate"); ?>",
            async: false,
            type: "POST",
            data: {filter: 4, userId: $('#user_id_buyer').val(), userType: $('#user_type_buyer').val(), start_date: $('#dp_users_start_buyer input').val(), end_date: $('#dp_users_end_buyer input').val()}
        }).responseText;
        $("#stat_div_buyer").html(html);
    }
</script>