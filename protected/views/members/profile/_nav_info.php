<div class="uk-margin-bottom">
    <span class="uk-h1 uk-margin-right"><?php echo CHtml::encode($user->username); ?></span>
    <span class="uk-h4"><b><?php echo CHtml::encode($user->country->name); ?></b></span>
</div>

<div class="uk-margin-bottom">
    <?php if ($user->sellerProfile) : ?>

        <span class="point">
            <?php echo $user->sellerProfile->getTypeName(); ?> <?php echo Yii::t('base', 'seller'); ?>
        </span>
        <span class="uk-margin-left-mini">
            <?php echo $user->getSoldCount(); ?> <?php echo Yii::t('base', 'items sold'); ?>
        </span>

    <?php else : ?>
        <!--<?php echo Yii::t('base', 'buyer'); ?>-->
    <?php endif; ?>
</div>
<div class="uk-margin-large">
    <div class="uk-margin-small-bottom">
        <span class="uk-display-inline-block uk-margin-small-right"><?php echo Yii::t('base', 'Feedback'); ?>:</span>
        <input type="hidden" class="rating" data-filled="uk-icon-star" data-empty="uk-icon-star-o"
               data-fractions="2" value="<?php echo $user->getRating(); ?>" readonly>
    </div>
    <div class="uk-margin-left-xlarge uk-text-line-height">
        <?php echo Yii::t('base', 'Item as described'); ?> : <?php echo $user->getRating('description'); ?> / 5.0
        <br>
        <?php echo Yii::t('base', 'Ships within 48 hours'); ?> : <?php echo $user->getRating('shipment'); ?> / 5.0
        <br>
        <?php echo Yii::t('base', 'Quick to respond'); ?> : <?php echo $user->getRating('communication'); ?> / 5.0
        <br>
    </div>
</div>
<div class="uk-flex uk-flex-middle uk-margin-large-top">
    <span class="uk-margin-small-right share-span" data-uk-tooltip="{pos:'bottom'}"
        title="<?= Yii::t('base', 'reposting your listings increases your sales') ?>"><?= Yii::t('base', 'share') ?>:</span>
    <ul class="social-list">
        <li><a href="#"
               onclick="Share.facebook(location.origin + '/profile-<?=$user->id?>', '23-15.com', '<?= $this->createAbsoluteUrl('/images/logo.png') ?>', '<?=Yii::t('base', 'Shop & Sell Designer Fashion Online | Women, Men, Unisex')?>', '<?=Yii::t('base', 'Shop my wardrobe')?>')"><i
                    class="uk-icon-facebook"></i></a></li>
        <li><a href="#"
               onclick="Share.twitter(location.origin + '/profile-<?=$user->id?>', '<?=Yii::t('base', 'Shop my wardrobe')?>', '23-15.com')"><i
                    class="uk-icon-twitter"></i></a></li>
        <?php if ($user->id == Yii::app()->member->id): ?>
        <li><a href="#get-public-link"
                data-uk-modal="{center:true}"><i
                    class="uk-icon-share"></i></a></li>
        <?php endif; ?>
    </ul>
</div>

<div id="get-public-link" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center" id="report-div">

            <div class="offset3 span6 pull-left">
                <div class="uk-text-center uk-text-left-small uk-h1 uk-text-normal uk-margin-bottom" style="font-size:24px"><?=Yii::t('base', 'SHARE YOUR WARDROBE')?></div>
            </div>

            <div class="offset3 span6 pull-left">
                <?php $publicUrl = Yii::app()->createAbsoluteUrl('members/profile/showProfile', array('id' => $user->id)); ?>
                <div class="uk-text-center uk-text-left-small uk-h4 uk-text-normal uk-margin-large-bottom" style="font-size:14px">
                    <a href="<?= $publicUrl ?>" target="blank" class="uk-base-link" id="filter-link">
                        <?= $publicUrl ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>