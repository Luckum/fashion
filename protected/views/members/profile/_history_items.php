
<div class="uk-margin-neg-top-small uk-margin-left uk-margin-right">
    <ul data-uk-switcher="{connect:'#account-history'}" class="uk-list-switcher uk-list-switcher-light uk-margin-bottom">
        <li><a href=""><?php echo Yii::t('base', 'list of orders'); ?></a></li>
<!--        <li><a href="">--><?php //echo Yii::t('base', 'sold items'); ?><!--</a></li>-->
    </ul>
    <ul id="account-history" class="uk-switcher switcher-custom">
        <!--FIRST ELEMENT SWITCHER IN HISTORY BLOCK-->
        <li>
            <div class="history_items_header">
                <div class="uk-grid uk-margin-small-bottom">
                    <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6">
                        <b><?php echo Yii::t('base', 'order'); ?> #</b>
                    </div>
                    <div class="uk-width-1-2 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2 uk-push-1-6">
                        <b><?php echo Yii::t('base', 'date of purchase'); ?></b>
                    </div>
                    <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6 padding-left-small-screen">
                        <b># <?php echo Yii::t('base', 'items'); ?></b>
                    </div>
                    <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6 padding-left-small-screen">
                        <b><?php echo Yii::t('base', 'total'); ?></b>
                    </div>
                </div>
            </div>
            <div class="uk-accordion" id="order-accordion"
                 data-uk-accordion="{showfirst: false, toggle: '.accordion-title-custom', containers: '.accordion-content-custom', clsactive: 'active-custom'}">

                <?php foreach($user->orders as $order): ?>
                <div class="accordion-title-custom">
                    <div class="uk-grid" data-id="<?php echo $order->id; ?>">
                        <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6">
                            #<?php
                                if ($order->id < 10) echo '0';
                                echo $order->id;
                            ?>
                        </div>
                        <div class="uk-width-1-2 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2 uk-push-1-6">
                            <div class="uk-text-left-mini">
                                <?php echo date('d.m.Y', strtotime($order->added_date)); ?>
                            </div>
                        </div>
                        <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6 padding-left-small-screen">
                            <?php echo count($order->orderItems); ?>
                        </div>
                        <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6 padding-left-small-screen">
                            &euro;<?php echo $order->total; ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-content-custom">
                    <?php foreach($order->orderItems as $order_item): ?>
                    <div class="uk-grid item<?php echo $order->id; ?>">
                        <div class="uk-width-1-1 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-1">
                            <div>
                                <?php echo CHtml::image(
                                    Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $order_item->product->image1,
                                    CHtml::encode($order_item->product->title)); ?>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                            <div class="uk-text-line-height">
                                <b><?php echo Brand::getFormatedTitle(CHtml::encode($order_item->product->brand->name)); ?></b>
                                <div><?php echo Product::getFormatedTitle(CHtml::encode($order_item->product->title)); ?></div>
                                <div>
                                    <?php echo Yii::t('base', 'size') . ': ' . (empty($order_item->product->size_chart) ? Yii::t('base', 'No size') : $order_item->product->size_chart->size); ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php echo Yii::t('base', 'colour') . ': ' . $order_item->product->color; ?>
                                </div>
                                <div>
                                    <?php echo Yii::t('base', 'condition') . ': ' . CHtml::encode($order_item->product->getConditionsName()); ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php echo Yii::t('base', 'ID') . ': ' . CHtml::encode($order_item->product->id); ?>
                                </div>
                                <div>
                                    <?php echo Yii::t('base', 'seller') . ': ' . CHtml::encode($order_item->product->user->username); ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php
                                    $model = Rating::model()->findAll('product_id = :productID AND user_id = :userID', array(':productID' => $order_item->product->id,':userID' => Yii::app()->member->id));
                                    //if(count($model) == 0 && in_array($order_item -> shipping_status, array(OrderItem::OI_SHIP_STATUS_COMPLETE))) : 
                                    if(count($model) == 0) :?>
                                        <a class="uk-base-link review-link" href="#review-product" data-uk-modal="{center:true}" data-id="<?php echo $order_item->product->id?>"><?=Yii::t('base', 'leave a feedback')?></a>
                                        <br/>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-1 review">
                            <?php if (in_array($order_item -> status, array(OrderItem :: OI_STATUS_SHIPPED, OrderItem :: OI_STATUS_RECEIVED)) && $order_item -> shipping_status != OrderItem :: OI_SHIP_STATUS_RETURNED): ?>
                                <br/>
                                <a href="#change-status" data-status="<?=$order_item -> status ==  OrderItem :: OI_STATUS_SHIPPED? OrderItem :: OI_STATUS_RECEIVED : OrderItem :: OI_SHIP_STATUS_RETURNED?>" data-uk-modal="{center:true}" data-oid="<?=$order_item->order_id?>" data-pid="<?=$order_item->product->id?>"><?=Yii::t('base', 'Change Status')?></a>
                            <?php endif; ?>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-1">
                            <div>
                                &euro;<?php echo $order_item->price; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

            </div>
        </li>
        <!--END FIRST ELEMENT SWITCHER IN HISTORY BLOCK-->
        <!--SECOND ELEMENT SWITCHER IN HISTORY BLOCK-->
        <li>
            <table class="uk-table uk-table-bag">
                <thead>
                <tr>
                    <th><b><?php echo Yii::t('base', 'item'); ?></b></th>
                    <th></th>
                    <th><b><?php echo Yii::t('base', 'date'); ?></b></th>
                    <th><b><?php echo Yii::t('base', 'price'); ?></b></th>
                    <th><b><?php echo Yii::t('base', 'revenue'); ?></b></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items_sold as $key => $item): ?>
                    <?php if($key == 0) continue; ?>

                    <tr>
                        <?php
                            $productUrl = $this->createAbsoluteUrl(Product::getProductUrl($item->product->id, $item->product));
                            $brandUrl = Brand::getBrandLink($item->product->brand->name);
                            $brandName = Brand::getFormatedTitle(CHtml::encode($item->product->brand->name));
                            $productName = Product::getFormatedTitle(CHtml::encode($item->product->title));
                        ?>
                        <td data-th="item" class="bag-img">
                            <a href="<?= $productUrl ?>" title="<?= $productName ?>">
                                <?php echo CHtml::image(
                                    Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $item->product->image1,
                                    CHtml::encode($item->product->title),
                                    array(
                                        'style' => 'width: 80%;'
                                    )
                                ); ?>
                            </a>
                        </td>
                        <td data-th="" class="bag-info">
                            <b>
                                <a href="<?= $brandUrl ?>" title="<?= $brandName ?>">
                                    <?php echo $brandName; ?>
                                </a>
                            </b>
                            <div class="uk-margin-bottom">
                                <a href="<?= $productUrl ?>" title="<?= $productName ?>">
                                    <?php echo $productName; ?>
                                </a>
                            </div>
                            <div><?php echo Yii::t('base', 'Size') . ': ' . (empty($item->product->size_chart) ? Yii::t('base', 'No size') : $item->product->size_chart->size); ?></div>
                            <div><?php echo Yii::t('base', 'Colour') . ': ' . $item->product->color; ?></div>
                            <div><?php echo Yii::t('base', 'Condition') . ': ' . CHtml::encode($item->product->getConditionsName()); ?></div>
                            <div><?php echo Yii::t('base', 'ID') . ': ' . CHtml::encode($item->product->id); ?></div>
                            <div><?php echo Yii::t('base', 'Seller') . ': ' . CHtml::encode($item->product->user->username); ?></div>
                        </td>
                        <td data-th="date">
                            <?php echo date('d.m.Y', strtotime($item->order->added_date)); ?>
                        </td>
                        <td data-th="price">
                            &euro;<?php echo $item->price; ?>
                        </td>
                        <td data-th="revenue">&euro;<?php echo $item->price * (1 - $item->comission_rate); ?></td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="uk-block-divider"></div>
            <div class="uk-padding-small-top uk-padding-small-bottom">
                <div class="uk-text-right uk-margin-right">
                    <b><?php echo Yii::t('base', 'total revenue'); ?>: &euro;<?php echo $items_sold[0]; ?></b></div>
            </div>
        </li>
        <!--END SECOND ELEMENT SWITCHER IN HISTORY BLOCK-->
    </ul>
</div>

<div id="review-product" class="uk-modal uk-modal-review">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center" id="review-div">
        </div>
    </div>
</div>

<div id="change-status" class="uk-modal uk-modal-review">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center" id="change-status-div">
            <p><?=Yii::t('base', 'Please select the desired status of product and click &laquo;Apply&raquo;')?></p>
            <div class="uk-form-controls uk-form-select uk-margin-top">
                <?=CHtml::dropDownList(
                    'up-status', '',
                    array(),
                    array('id' => 'up-status', 'class' => 'js-select', 'empty' => Yii::t('base', 'Select status'))
                )?>
            </div>
            <br/>
            <div>
                <b><?php echo CHtml::button(Yii::t('base', 'Apply'), array('class'=>'uk-button uk-button set-received-status')); ?></b>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    // reinitialize component
    //
    $(document).ready(function(){
        var options = {
            showfirst: false,
            toggle: '.accordion-title-custom',
            containers: '.accordion-content-custom',
            clsactive: 'active-custom'
        };

        UIkit.accordion($('#order-accordion'), options);
    });

</script>