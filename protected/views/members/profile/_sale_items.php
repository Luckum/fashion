<!--ITEMS-->
<div class="div-dom-inserted-event">
    <div class="uk-margin-right uk-margin-left">
        <div class="uk-h4 uk-margin-bottom uk-margin-neg-top-small">
            <b><?php echo Yii::t('base', 'Items for sale'); ?></b>
        </div>

        <?php
        $isValidUser = false;
        $validUserId = 0;

        if (!empty(Yii::app()->member->id)) {
            if (isset($_GET['id'])) {
                if ($_GET['id'] == Yii::app()->member->id) { // first load
                    $isValidUser = true;
                    $validUserId = Yii::app()->member->id;
                }
            } else {
                if (isset($userId) && !empty($userId)) { // after product update
                    $isValidUser = true;
                    $validUserId = Yii::app()->member->id;
                }
            }
        } ?>

        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
            <?php if ($isValidUser): ?>
                <div>
                    <div class="image-preview_account uk-margin-bottom">
                        <label for="image-upload" id="image-label" class="load-image image-label_account">
                            <?php echo Yii::t('base', 'add new item for sale'); ?>
                        </label>
                        <!--JS-USE-CLASS(add_item)-->
                        <input type="file" name="image" id="image-upload" class="image-upload_account add_item">
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($model): ?>
                <?php if ($model[0]): ?>
                    <div>
                        <div class="thumbnail-wrapper uk-padding-bottom">
                            <div class="thumbnail">
                                <?php if ($isValidUser): ?>
                                    <div class="list-link">
                                        <div class="edit uk-float-left">
                                            <?php echo CHtml::link(
                                                Yii::t('base', 'edit'),
                                                strtolower($this->createAbsoluteUrl('/my-account/sellUpdate/' . $model[0]->id)),
                                                array(
                                                    'class' => 'uk-base-link uk-margin-left-mini'
                                                ));
                                            ?>
                                        </div>
                                        <div class="reduce uk-float-left">
                                            <?php echo CHtml::link(
                                                Yii::t('base', 'reduce price'),
                                                '#',
                                                array(
                                                    'class' => 'uk-base-link uk-margin-left-mini reduce-price'
                                                ));
                                            ?>
                                        </div>
                                        <div class="remove uk-float-left" data-id="<?php echo $model[0]->id; ?>">
                                            <?=CHtml :: link('',
                                                strtolower($this -> createAbsoluteUrl('/members/profile/confirmRemove/' . $model[0]->id)),
                                                array('class' => 'delete-item uk-margin-left-mini')
                                            )?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <a href="#" class="uk-display-block">
                                    <div class="thumbnail-image">
                                        <?php echo CHtml::link(
                                            CHtml::image(
                                                Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_MEDIUM_DIR . $model[0]->image1,
                                                $model[0]->title,
                                                array('onerror' => '$(this).prop({"class" : "no-image", "src" : "/images/prod-no-img.png"})')
                                            ),
                                            $this->createAbsoluteUrl(Product::getProductUrl($model[0]->id)));
                                        ?>
                                    </div>
                                    <div class="uk-h4 thumbnail-title uk-margin-top">
                                        <?php echo Brand::getFormatedTitle(CHtml::encode($model[0]->brand->name)); ?>
                                    </div>
                                </a>
                                <div class="thumbnail-description uk-margin-large-left uk-margin-top-mini">
                                    <?php echo Product::getFormatedTitle(CHtml::encode($model[0]->title)); ?>
                                </div>
                                <div class="thumbnail-details uk-margin-large-left">

                                    <?php
                                    $old_price = $model[0]->init_price;
                                    $new_price = $model[0]->price;
                                    $equal = $old_price === $new_price;
                                    ?>

                                    <span class="<?php echo !$equal ? 'price price-old' : 'price' ?>">
                                    &euro;<?php echo $old_price;; ?>
                                 </span>
                                    <?php if (!$equal): ?>
                                        <span class="price-new">
                                        &euro;<?php echo $new_price; ?>
                                    </span>
                                    <?php endif; ?>

                                    <span class="size">
                            size: <?= empty($model[0]->size_chart) ? Yii:: t('base', 'No size') : $model[0]->size_chart->size ?>
                        </span>
                                </div>
                            </div>
                            <div class="thumbnail-click-block">
                                <form action="#"
                                      class="custom-form uk-form uk-form-modal uk-text-center uk-text-line-height">
                                    <div><?php echo Yii::t('base', 'current price'); ?></div>
                                    <div class="uk-h2">
                                        &euro;<?php echo $model[0]->price; ?>
                                        <?php echo CHtml::hiddenField(
                                            'Product_price_' . $model[0]->id,
                                            $model[0]->price,
                                            array('class' => 'Product_price'));
                                        ?>
                                    </div>
                                    <div>
                                        <?php echo Yii::t('base', 'you get'); ?>
                                        &nbsp;&euro;<?php echo $model[0]->price *
                                            ((isset($model[0]->user->sellerProfile->comission_rate)) ?
                                                1 - $model[0]->user->sellerProfile->comission_rate :
                                                1 - Yii::app()->params['payment']['default_comission_rate']); ?>
                                    </div>
                                    <div class="uk-margin-small-top">
                                        <b>
                                            <?php echo CHtml::label(
                                                Yii::t('base', 'type a new price'),
                                                'Product[new_price]'
                                            ); ?>
                                        </b>
                                    </div>
                                    <div class="uk-form-mini">
                                        <?php echo CHtml::textField(
                                            'Product[new_price][' . $model[0]->id . ']',
                                            '',
                                            array('class' => 'new_price_r price')); ?>
                                    </div>
                                    <div>
                                        <?php echo Yii::t('base', 'you get'); ?>
                                        &nbsp;&euro;<span
                                            class='new_price_get'>00,00</span>
                                    </div>
                                    <div class="uk-margin-small-top uk-margin-small-bottom">or</div>
                                    <div><b>
                                            <?php echo CHtml::label(
                                                Yii::t('base', 'reduce by'),
                                                'Product[new_percentage]'
                                            ); ?>
                                        </b></div>
                                    <div>
                                        <div class="uk-form-mini">
                                            <?php echo CHtml::textField(
                                                'Product[new_percentage][' . $model[0]->id . ']',
                                                '',
                                                array('class' => 'new_percentage price')); ?>
                                        </div>
                                        <span>%</span>
                                    </div>
                                    <div>
                                        <?php echo Yii::t('base', 'new price'); ?>
                                        = &euro;<span class='per_new_price'></span>
                                    </div>
                                    <div style="margin-bottom: 12px;">
                                        <?php echo Yii::t('base', 'you get'); ?>
                                        &euro;<span
                                            class='per_new_price_get'></span>
                                    </div>
                                    <?php echo CHtml::submitButton(
                                        Yii::t('base', 'submit'),
                                        array(
                                            'class' => 'uk-button uk-margin-small-top subm_reduce',
                                            'data-id' => $model[0]->id)); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if ($model): ?>
            <?php if (($count = count($model)) > 1): ?>
                <?php for ($i = 1; $i < $count; $i++): // $model[0] doesn't used     ?>
                    <?php if ($i % 2 != 0) { ?>
                        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
                        <div>
                    <?php } else { ?>
                        <div>
                    <?php } ?><!--WRAPPER-->

                    <div class="thumbnail-wrapper uk-padding-bottom">
                        <div class="thumbnail">
                            <?php if ($isValidUser): ?>
                                <div class="list-link">
                                    <div class="edit uk-float-left">
                                        <?php echo CHtml::link(
                                            Yii::t('base', 'edit'),
                                            strtolower($this->createAbsoluteUrl('/my-account/sellUpdate/' . $model[$i]->id)),
                                            array(
                                                'class' => 'uk-base-link uk-margin-left-mini'
                                            ));
                                        ?>
                                    </div>
                                    <div class="reduce uk-float-left">
                                        <?php echo CHtml::link(
                                            Yii::t('base', 'reduce price'),
                                            '#',
                                            array(
                                                'class' => 'uk-base-link uk-margin-left-mini reduce-price'
                                            ));
                                        ?>
                                    </div>
                                    <div class="remove uk-float-left" data-id="<?php echo $model[$i]->id; ?>">
                                        <?=CHtml :: link('',
                                            strtolower($this -> createAbsoluteUrl('/members/profile/confirmRemove/' . $model[$i]->id)),
                                            array('class' => 'delete-item uk-margin-left-mini')
                                        )?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <a href="#" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <?php echo CHtml::link(
                                        CHtml::image(
                                            Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_MEDIUM_DIR . $model[$i]->image1,
                                            ($model[$i]->title) ? $model[$i]->title : Category::model()->getAliasById($model[$i]->category_id) ,
                                            array('onerror' => '$(this).prop({"class" : "no-image", "src" : "/images/prod-no-img.png"})')
                                        ),
                                        $this->createAbsoluteUrl(Product::getProductUrl($model[$i]->id)));
                                    ?>
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?php echo Brand::getFormatedTitle(CHtml::encode($model[$i]->brand->name)); ?>
                                </div>
                            </a>
                            <div class="thumbnail-description uk-margin-large-left uk-margin-top-mini">
                                <?php echo Product::getFormatedTitle(CHtml::encode($model[$i]->title)); ?>
                            </div>
                            <div class="thumbnail-details uk-margin-large-left">

                                <?php
                                $old_price = $model[$i]->init_price;
                                $new_price = $model[$i]->price;;
                                $equal = $old_price === $new_price;
                                ?>

                                <span class="<?php echo !$equal ? 'price price-old' : 'price' ?>">
                                &euro;<?php echo $old_price;; ?>
                            </span>
                                <?php if (!$equal): ?>
                                    <span class="price-new">
                                    &euro;<?php echo $new_price; ?>
                                </span>
                                <?php endif; ?>

                                <span class="size">
                        size: <?= empty($model[$i]->size_chart) ? Yii:: t('base', 'No size') : $model[$i]->size_chart->size ?>
                    </span>
                            </div>
                        </div>
                        <div class="thumbnail-click-block">
                            <form action="#"
                                  class="custom-form uk-form uk-form-modal uk-text-center uk-text-line-height">
                                <div><?php echo Yii::t('base', 'current price'); ?></div>
                                <div class="uk-h2">
                                    &euro;<?php echo $model[$i]->price; ?>
                                    <?php echo CHtml::hiddenField(
                                        'Product_price_' . $model[$i]->id,
                                        $model[$i]->price,
                                        array('class' => 'Product_price'));
                                    ?>
                                </div>
                                <div>
                                    <?php echo Yii::t('base', 'you get'); ?>
                                    &nbsp;&euro;<?php echo $model[$i]->price *
                                        ((isset($model[$i]->user->sellerProfile->comission_rate)) ?
                                            1 - $model[$i]->user->sellerProfile->comission_rate :
                                            1 - Yii::app()->params['payment']['default_comission_rate']); ?>
                                </div>
                                <div class="uk-margin-small-top">
                                    <b>
                                        <?php echo CHtml::label(
                                            Yii::t('base', 'type a new price'),
                                            'Product[new_price]'
                                        ); ?>
                                    </b>
                                </div>
                                <div class="uk-form-mini">
                                    <?php echo CHtml::textField(
                                        'Product[new_price][' . $model[$i]->id . ']',
                                        '',
                                        array('class' => 'new_price_r price')); ?>
                                </div>
                                <div>
                                    <?php echo Yii::t('base', 'you get'); ?>
                                    &nbsp;&euro;<span
                                        class='new_price_get'>00,00</span>
                                </div>
                                <div class="uk-margin-small-top uk-margin-small-bottom">or</div>
                                <div><b>
                                        <?php echo CHtml::label(
                                            Yii::t('base', 'reduce by'),
                                            'Product[new_percentage]'
                                        ); ?>
                                    </b></div>
                                <div>
                                    <div class="uk-form-mini">
                                        <?php echo CHtml::textField(
                                            'Product[new_percentage][' . $model[$i]->id . ']',
                                            '',
                                            array('class' => 'new_percentage price')); ?>
                                    </div>
                                    <span>%</span>
                                </div>
                                <div>
                                    <?php echo Yii::t('base', 'new price'); ?>
                                    = &euro;<span class='per_new_price'></span>
                                </div>
                                <div>
                                    <?php echo Yii::t('base', 'you get'); ?>
                                    &euro;<span
                                        class='per_new_price_get'></span>
                                </div>
                                <?php echo CHtml::submitButton(
                                    Yii::t('base', 'submit'),
                                    array(
                                        'class' => 'uk-button uk-margin-small-top subm_reduce',
                                        'data-id' => $model[$i]->id)); ?>
                            </form>
                        </div>
                    </div>

                    <?php if ($i % 2 != 0 && $i < ($count - 1)) { ?><!--END WRAPPER-->
                        </div>
                    <?php } else { ?>
                        </div></div>
                    <?php } ?>
                <?php endfor; ?>
            <?php endif; // --- $model contains more, than 1 ?>
        <?php endif; // ------- $model exists ?>
    </div>
</div>
<!--END ITEMS-->

<script type="text/javascript">

    // re-activate modal form for reduce price
    //
    if (typeof thumb_click != 'undefined') {
        thumb_click();
    }
</script>

<script type="text/javascript">

    // --- hide block of reduce price if click out him
    //
    $(document).click(function (e) {
        var obj = $(e.target).closest('.thumbnail-click-block');
        var flag = false;

        if (obj[0]) {
            flag = obj[0].className = 'thumbnail-click-block';
        }

        if (!flag) $('.thumbnail-click-block').hide();
    });

    $('.reduce').off('click').on('click', function () {
        $(this).closest('.product_img').prev().toggle();
        return false;
    });

    $('.reduce_block .close').off('click').on('click', function () {
        $(this).parent().hide();
        return false;
    });

    $('.new_price_r').off('keyup').on('keyup', function (e) {
        this.value = this.value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        var price = ($(this).val() * "<?=(isset($user->sellerProfile->comission_rate)) ? 1 - $user->sellerProfile->comission_rate : 1 - Yii::app()->params['payment']['default_comission_rate']?>").toFixed(2);
        $(this).parent().parent().find('.new_price_get').empty();
        $(this).parent().parent().find('.new_price_get').text(price);
    });

    $('.new_percentage').off('keyup').on('keyup', function (e) {
        this.value = this.value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        var oldPrice = $(this).closest('.custom-form').find('.Product_price').val();
        var price = (oldPrice * ((100 - $(this).val()) / 100)).toFixed(2);

        $(this).parent().parent().parent().find('.per_new_price').empty();
        $(this).parent().parent().parent().find('.per_new_price').text(price);

        var get_price = (price * "<?=(isset($user->sellerProfile->comission_rate)) ? 1 - $user->sellerProfile->comission_rate : 1 - Yii::app()->params['payment']['default_comission_rate']?>").toFixed(2);
        $(this).parent().parent().parent().find('.per_new_price_get').empty();
        $(this).parent().parent().parent().find('.per_new_price_get').text(get_price);
    });

    $('.subm_reduce').off('click').on('click', function () {
        var price;
        if ($(this).closest('.custom-form').find('.per_new_price').text()) {
            price = $(this).closest('.custom-form').find('.per_new_price').text();
        } else if ($(this).closest('.custom-form').find('.new_price_r').val()) {
            price = $(this).closest('.custom-form').find('.new_price_r').val();
        } else {
            return false;
        }

        $.ajax({
            type: 'POST',
            data: {id: $(this).data('id'), price: price},
            url: globals.url + '/members/profile/changePrice',
            success: function (data, textStatus, jqXHR) {
                $("#sale_items").html(data);
            }
        });
        return false;
    });

    $('#cancel_delete').off('click').on('click', function () {
        $.fancybox.close();
        return false;
    });

    $('.delete-item').off('click').on('click', function () {

        $.ajax({
            url: this.href,
            success: function (data) {
                $('#div-delete-item-modal').html(data);
            }
        });

        return false;
    });

</script>
