<?php $this->widget('application.components.ModalFlash'); ?>

<div class="uk-grid">
    <div class="uk-width-1-1 uk-width-large-5-6 uk-width-medium-5-6 uk-width-small-1-1 uk-push-1-6">
        <div class="uk-margin-small-bottom">
            <b>
                <?php echo Yii::t('base', 'Review your bag'); ?>
                (<span id="cart_bag_count"><?php
                    echo Yii::app()->shoppingCart->getItemsCntText();
                    ?></span>)
            </b>
        </div>
        <div class="uk-hidden-large uk-block-border">
            <div class="uk-text-center uk-margin-bottom"><b><?= Yii::t('base', 'Order summary') ?></b></div>
            <div class="uk-flex uk-flex-center uk-text-line-height">
                <div class="uk-text-right uk-margin-right">
                    <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Your cart') ?></div>
                    <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Shipping') ?></div>
                    <div class="uk-margin-bottom-mini"><b><?= Yii::t('base', 'Total') ?></b></div>
                </div>
                <div>
                    <div class="uk-margin-bottom-mini">&euro;&nbsp;<span class="your_cart_cost"><?= $total ?></span>
                    </div>
                    <div class="uk-margin-bottom-mini">&euro;&nbsp;<span class="shipping_cost"></span></div>
                    <div class="uk-margin-bottom-mini"><b>&euro;&nbsp;<span class="total_cost"><?= $total ?></span></b>
                    </div>
                </div>
            </div>
            <div class="uk-text-center uk-margin-large-top">
                <a href="#" class="uk-button cart_checkout_link"><?= Yii::t('base', 'checkout') ?></a>
            </div>
            <div class="uk-text-center uk-margin-top">
                <a class="uk-base-link" href="#"
                   class="uk-base-link">‹ <?php echo CHtml::link(Yii::t('base', 'continue shopping'), $returnUrl); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="uk-grid">
    <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
        <table class="uk-table uk-table-condensed uk-table-bag">
            <thead>
            <tr>
                <th></th>
                <th><b class="uk-margin-left"><?= Yii::t('base', 'Product') ?></b></th>
                <th><b class="uk-margin-left"><?= Yii::t('base', 'Shipping from') ?></b></th>
                <th><b><?= Yii::t('base', 'Remove') ?></b></th>
                <th><b><?= Yii::t('base', 'Unit price') ?></b></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (Yii::app()->shoppingCart->getPositions() as $product): ?>
                <tr data-id="<?= $product->getId() ?>">
                    <td data-th=""
                        class="uk-width-large-1-10 uk-width-medium-1-10 uk-width-small-1-1">
                        <?= CHtml::image(Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $product->image1, $product->title,
                            array('class' => 'cart_prod_image')) ?>
                    </td>
                    <td data-th="Product"
                        class="uk-width-large-4-10 uk-width-medium-4-10 uk-width-small-1-1">
                        <div class="uk-margin-left with-right-indent">
                            <b><?= CHtml::encode($product->brand->name) ?></b>
                            <div class="uk-margin-bottom wb"><?= CHtml::encode($product->description) ?></div>
                            <div>
                                <span class="size uk-margin-right"><?=Yii::t('base','size')?>: <?=empty($product -> size_chart) ? Yii :: t('base', 'No size') : $product -> size_chart -> size?></span>
                                <span class="size uk-margin-right"><?=Yii::t('base','color')?>: <?= CHtml::encode($product->color) ?></span>
                                <span class="size"><?=Yii::t('base','condition')?>: <?=CHtml::encode($product->getConditionsName()) ?></span>
                            </div>
                            <div>ID: <?= $product->id ?></div>
                        </div>
                    </td>
                    <td data-th="Shipping from"
                        class="uk-width-large-2-10 uk-width-medium-2-10 uk-width-small-1-1">
                        <div class="uk-margin-left">
                            <?php
                            if (isset($product->user->country->name)) echo CHtml::encode($product->user->country->name);
                            ?>
                            <br> <?= Yii::t('base', 'est. shipping cost') ?> &euro;&nbsp;<?= ShippingRate::getRate($product->user->country_id, $user->country_id) ?>
                        </div>
                    </td>
                    <td data-th="Remove"
                        class="uk-width-large-1-10 uk-width-medium-1-10 uk-width-small-1-1">
                        <a href="#" data-id="<?= $product->getId() ?>" class="delete-item"></a>
                    </td>
                    <td data-th="Unit price"
                        class="uk-width-large-1-10 uk-width-medium-1-10 uk-width-small-1-1">
                        &euro;&nbsp;<?= $product->price ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="uk-width-1-1 uk-width-large-1-4 uk-width-medium-1-1 uk-width-small-1-1">
        <div class="uk-block-border uk-visible-large">
            <div class="uk-text-center uk-margin-bottom"><b><?= Yii::t('base', 'Order summary') ?></b></div>
            <div class="uk-flex uk-flex-center uk-text-line-height">
                <div class="uk-text-right uk-margin-right">
                    <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Your cart') ?></div>
                    <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Shipping') ?></div>
                    <div class="uk-margin-bottom-mini"><b><?= Yii::t('base', 'Total') ?></b></div>
                </div>
                <div>
                    <div class="uk-margin-bottom-mini">&euro;&nbsp;<span class="your_cart_cost"><?= $total ?></span>
                    </div>
                    <div class="uk-margin-bottom-mini">&euro;&nbsp;<span class="shipping_cost"></span></div>
                    <div class="uk-margin-bottom-mini"><b>&euro;&nbsp;<span class="total_cost"><?= $total ?></span></b>
                    </div>
                </div>
            </div>
            <div class="uk-text-center uk-margin-large-top">
                <a href="#" class="uk-button cart_checkout_link"><?= Yii::t('base', 'checkout') ?></a>
            </div>
            <div class="uk-text-center uk-margin-top">
                <?php echo CHtml::link('‹ ' . Yii::t('base', 'continue shopping'), $returnUrl, array('class' => 'uk-base-link')); ?>
            </div>
        </div>
    </div>
</div>

<div class="uk-width-1-1 uk-width-large-6-10 uk-width-medium-5-6 uk-width-small-1-1 uk-push-1-10">
    <div class="uk-block-divider uk-padding-top"></div>
</div>
<div class="uk-width-1-1 uk-width-large-6-10 uk-width-medium-5-6 uk-width-small-1-1 uk-push-1-10">
    <div class="uk-block-divider uk-padding-top uk-padding-bottom">
        <div class="uk-text-right uk-margin-right"><?= Yii::t('base', 'Subtotal') ?>: &euro;&nbsp;<span
                id="subtotal_cost"><?= $total ?></span></div>
    </div>
</div>
<div class="uk-width-1-1 uk-width-large-6-10 uk-width-medium-5-6 uk-width-small-1-1 uk-push-1-10">
    <div class="uk-block-divider uk-padding-top uk-padding-bottom">
        <div class="uk-grid">
            <div class="uk-width-3-4">
                <span
                    class="uk-margin-small-right"><?= CHtml::label(Yii::t('base', 'Where are you shipping to?'), "shipping") ?></span>
                <div class="form-bag">
                    <!--                                        --><?php //echo CHtml::dropDownList(
                    //                                                'shipping',
                    //                                                "",
                    //                                                Country::getListIdCountry(),
                    //                                                array('class'=>'selectsort js-select')
                    //                                            );
                    //                                        ?>
                    <input id="shipping" class="country_input input-country-style" type="text" />
                    <input id="hidden_shipping" name="shipping" type="hidden" class="country_hidden" />
                </div>
            </div>
            <div class="uk-width-1-4">
                <div class="uk-text-right uk-margin-right"><?= Yii::t('base', 'Shipping') ?>: <span>&euro;&nbsp;<span
                            class="shipping_cost"></span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-text-right uk-margin-right uk-padding-top uk-padding-bottom"><b><?= Yii::t('base', 'Total') ?>
            : &euro;&nbsp;<span class="total_cost"><?= $total ?></span></b></div>
    <div class="uk-grid uk-margin-large-top uk-flex uk-flex-middle">
        <div class="uk-width-1-2">
            <?php echo CHtml::link('‹ ' . Yii::t('base', 'continue shopping'), $returnUrl, array('class' => 'uk-base-link')); ?>
        </div>
        <div class="uk-width-1-2 uk-text-right">
            <a href="#" class="uk-button cart_checkout_link"><?= Yii::t('base', 'checkout') ?></a>
        </div>
    </div>
</div>
