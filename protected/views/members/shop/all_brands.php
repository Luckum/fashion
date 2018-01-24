<!--MAIN BLOCK-->
<div class="uk-block uk-margin-large-top">
    <div class="uk-container uk-container-center">
        <div class="uk-h1 uk-text-center"><?=Yii :: t('base', 'Brands')?></div>
    </div>
</div>
<div class="uk-block-border-horizontal">
    <div class="uk-container uk-container-center">
        <div class="uk-text-center">
            <ul id="brands-alphabet" class="uk-list list-inline">
                <?php foreach ($alphabet as $item): ?>
                    <li><a href="#<?=$item?>"><?=$item?></a></li>
                <?php endforeach; ?>
                <li><a href="#all">(ALL)</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="uk-block uk-text-line-height">
    <div class="uk-container uk-container-center">
        <div id="brands-list" class="column">
            <?php foreach ($brands as $key => $data): ?>
                <ul class="uk-list uk-list-brand uk-margin-top-remove uk-margin-large-bottom" data-category="<?=$key?>">
                    <li><div class="uk-h3"><b><?=$key?></b></div></li>
                    <?php foreach ($data as $item): ?>
                        <?php 
                            $brandName = Brand::getFormatedTitle(CHtml::encode($item));
                         ?>
                        <li><a href="<?php echo Brand::getBrandLink($item); ?>" title="brand '<?= $brandName ?>'"><?= $brandName ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--END MAIN BLOCK-->

<script>
    $(document).ready(function() {
        $('#brands-alphabet a').on('click', function() {
            var container = $('#brands-list');
            var brands    = container.find('ul');
            var href      = $(this).prop('href');
            var cat       = href.substr(href.indexOf('#') + 1);
            var e         = $('ul[data-category="' + cat + '"]');

            if (cat == 'all') {
                brands.show();
            } else {
                brands.hide();
                if (e.length) {
                    e.show();
                } else {
                    // There are no brands associated to category "' + (cat.toUpperCase()) + '"'
                }
            }
        });
    });
</script>