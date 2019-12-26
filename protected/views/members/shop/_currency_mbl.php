<?php $current_currency = Currency::getCurrency() ?>
<?php $currencies_list = Currency::getList(); ?>
<a href="javascript:void(0)" class="main_menu_link" id="currency-nav-cnt-lnk" onclick="showCurrency();"><?= $current_currency->name . '&nbsp;' . $current_currency->sign; ?></a>
<div class="uk-dropdown dropdown-nav" style="width: 63px; display: none;margin-top: 13px;" id="currency-nav-cnt">
    <ul class="uk-nav uk-dropdown-nav">
        <?php foreach ($currencies_list as $currency): ?>
            <li style="display: block;"><a style="font-size: 14px; color: #000; padding-right:0;text-align: right;" href="javascript:void(0);" onclick="setCurrency('<?= $currency->id ?>')"><?= $currency->name . '&nbsp;' . $currency->sign ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>