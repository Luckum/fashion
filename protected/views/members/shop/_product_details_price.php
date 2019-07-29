<?php if($model->isVisible): ?>
    <?php if($model->price == $model->init_price): ?>
        <div class="uk-h3-lg">
            <?= $currency->sign . number_format(sprintf("%01.2f", $model->price * $currency->currencyRate->rate), 2, '.', ''); ?>
        </div>
    <?php else: ?>
        <div class="uk-h3-lg price">
            <span style="margin-right:10px;text-decoration: line-through;">
                <?= $currency->sign . number_format(sprintf("%01.2f", $model->init_price * $currency->currencyRate->rate), 2, '.', ''); ?>
            </span>
            <span class="uk-h3-lg price price-new" style="color: red !important;">
                <?= $currency->sign . number_format(sprintf("%01.2f", $model->price * $currency->currencyRate->rate), 2, '.', ''); ?>
            </span>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="uk-h3-lg price">
        <span style="margin-right:10px;">
            <?= $currency->sign . number_format(sprintf("%01.2f", $model->price * $currency->currencyRate->rate), 2, '.', ''); ?>
        </span>
        <span class="uk-h3-lg price price-new">SOLD</span>
    </div>
<?php endif; ?>