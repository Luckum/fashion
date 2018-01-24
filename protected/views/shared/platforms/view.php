<h1>View Platform "<?=$model->domainname;?>"</h1>

    <h4>Platform Information</h4>
    <div class="row">
        <div class="span5">
            <div class="row">
                <?php echo CHtml::activeLabel($model,'domainname'); ?>
                <strong><?php echo $model->domainname; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('IP Ranges', ''); ?>
                <strong><?php echo nl2br($model->displayRanges()); ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::activeLabel($model,'rdns'); ?>
                <strong><?php echo $model->rdns; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::activeLabel($model,'ipid'); ?>
                <strong><?php echo ($model->ip) ? $model->ip->value : ''; ?></strong>
            </div>
<?php
if(!Yii::app()->staff->isGuest) {
?>
            <div class="row">
                <?php echo CHtml::activeLabel($model,'parentid'); ?>
                <strong><?php echo ($model->parentid !== null) ? $model->parent->domainname : 'None'; ?></strong>
            </div>
            <div class="row">
                <label>Injectors</label>
                <strong><?=nl2br($model->displayInjectors()); ?></strong>
            </div>
<?php
}
?>
        </div>
        <div class="span6">
            <div class="row">
                <?php echo CHtml::label('Can-Spam Address', ''); ?>
                <!-- h5>Can-Spam Address</h5 -->
                <address>
                    <!-- ?php echo nl2br($model->client->companyname); ?><br / -->
                    <?php echo nl2br($model->getCanSPAMAddress()); ?>
                </address>
            </div>
            <div class="row">
                <?php echo CHtml::activeLabel($model,'phonenumber'); ?>
                <strong><?php echo $model->phonenumber; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::activeLabel($model,'price'); ?>
                <strong><?php echo $model->price; ?> USD</strong>
            </div>
            <div class="row">
                <?php echo CHtml::activeLabel($model,'status'); ?>
                <strong><?php echo strtoupper($model->status); ?></strong>
            </div>
<?php
if(!Yii::app()->staff->isGuest) {
?>
            <div class="row">
                <?php echo CHtml::label('Slave Platforms', ''); ?>
                <strong>
                <?php
                foreach($model->childrens as $slave) {
                    echo CHtml::link($slave->domainname, array('view', 'id' => $slave->recordid)) . '<br />';
                }
                ?>
                </strong>
            </div>
<?php
}
?>
        </div>
    </div>
    <div class="row">
        <div class="span11">
            <div class="row">
                <?php echo CHtml::activeLabel($model,'notes'); ?>
                <div style="float: left"><strong><?php echo nl2br(CHtml::value($model, 'notes'));//$model->notes; ?></strong></div>
            </div>
        </div>
    </div>

    <h4>RBL Information</h4>
    <div class="row">
        <div class="span5">
            <div class="row">
                <?php echo CHtml::label('RBL Company Name', ''); ?>
                <strong><?php echo $model->rblcompanyname; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('RBL Company Role', ''); ?>
                <strong><?php echo $model->rblcompanyrole; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('RBL Company Phone', ''); ?>
                <strong><?php echo $model->rblcompanyphone; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('RBL Address', ''); ?>
                <address>
                    <?php echo nl2br($model->getRBLAddress()); ?>
                </address>
            </div>
        </div>
        <div class="span6">
            <div class="row">
                <?php echo CHtml::label('RBL Website', ''); ?>
                <strong><?php echo $model->rblwebsite; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('RBL Privacy Policy URL', ''); ?>
                <strong style="width: 200px"><?php echo $model->rblprivacypolicyurl; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('RBL Anti-Spam Policy URL', ''); ?>
                <strong><?php echo $model->rblantispampolicyurl; ?></strong>
            </div>
            <div class="row">
                <?php echo CHtml::label('RBL Unsubscribe URL', ''); ?>
                <strong><?php echo $model->rblunsubscribeurl; ?></strong>
            </div>
        </div>
    </div>