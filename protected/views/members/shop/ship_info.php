<!--Страница Shipping Info-->

<div id="shipinfo-page-wrapper" class="scrollbar-inner">

    <!--Заголовок-->
    <h1><?=Yii::t('base', 'shipping info')?></h1>

    <!--Таблица сведений об отгрузки для данного товара-->
    <?php if (count($rates)): ?>
    <table>
        <caption><?=Yii::t('base', 'The exact cost of shipping is calculated at checkout based on buyer’s and seller’s location and weight of the item.')?></caption>
        <tr>
            <th><?=Yii::t('base', 'seller‘s location')?></th>
            <th><?=Yii::t('base', 'buyer‘s location')?></th>
            <th><?=Yii::t('base', 'shipping fees')?></th>
        </tr>
        <?php foreach ($rates as $seller_country => $value) : ?>
        <tr>
            <td>
                <?=CHtml::encode($seller_country)?>
            </td>
            <td>
                <?php foreach ($value as $buyer_country => $rate) : ?>
                    <?=CHtml::encode($buyer_country)?><br/>
                <?php endforeach; ?>
            </td>
            <td>
                <?php foreach ($value as $buyer_country => $rate) : ?>
                    &euro; <?=$rate?><br/>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <?=Yii::t('base', 'There is no information about shipping.')?>
    <?php endif; ?>

</div>