<?php $current_currency = Currency::getCurrency() ?>
<?php $currencies_list = Currency::getList(); ?>
<a href="javascript:void(0)" class="main_menu_link"><?= $current_currency->name . '&nbsp;' . $current_currency->sign; ?></a>
<div class="uk-dropdown dropdown-nav" style="left: 0; width: auto;">
    <ul class="uk-nav uk-dropdown-nav">
        <?php foreach ($currencies_list as $currency): ?>
            <li style="display: block;"><a style="font-size: 14px; color: #000;" href="javascript:void(0);" onclick="setCurrency('<?= $currency->id ?>')"><?= $currency->name . '&nbsp;' . $currency->sign ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>