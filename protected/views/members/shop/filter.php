<!--MAIN BLOCK-->
<div class="uk-block uk-margin-large-top">
    <div class="uk-container uk-container-center">
        <!--HEADERS-->
        <div id="p-filter-link" class="uk-text-left">
            <hgroup>
                <h1><?=Yii::t('base', 'search')?></h1>
                <h2><?=count($products)?>&nbsp;<?=Yii::t('base', 'results have been found for')?></h2>
            </hgroup>
        </div>
        <!--END HEADERS-->
        <div id='products'>
            <?php $this->renderPartial('_filter',
                array(
                    'products' => $products,
                    'pages' => $pages,
                    'currency' => $currency
                )
            ); ?>
        </div>

    </div>
</div>
<!--END MAIN BLOCK-->