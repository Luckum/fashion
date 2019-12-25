<div class="uk-hidden-large mbl-tools-cnt">
    <div class="mbl-tools mbl-tools-sort" style="display: none;">
        <div class="mbl-tools-inner">
            <span>sort by:</span>
            <ul>
                <li><a href="javascript:void(0);" class="sort-lnk-mbl" data-sort="date_added">Latest arrivals</a></li>
                <li><a href="javascript:void(0);" class="sort-lnk-mbl" data-sort="asc">Price: Low to High</a></li>
                <li><a href="javascript:void(0);" class="sort-lnk-mbl" data-sort="desc">Price: High to low</a></li>
            </ul>
        </div>
        
        <div class="close-menu">
            <a href="javascript:void(0)" class="close-tools-lnk">Cancel</a>
        </div>
    </div>
    
    <div class="mbl-tools mbl-tools-filter" style="display: none;">
        <div class="mbl-tools-inner">
            <span>filter by:</span>
            <?php if (Category::getParentByCategory($model->id) != Category::getIdByAlias('featured')): ?>
                <?php $menu = UtilsHelper::getCategoryMenu($s_brand); ?>
                <?php $brands = Brand::getBrandsSorted($s_category, $s_subcategory); ?>
                <div style="display: inline-block; width: 100%;" id="side-menu" class="side-menu-mbl">
                    <ul style="list-style: none; padding-left: 0;">
                        <?php if (!empty($s_brand)): ?>
                            <li><span><b>CATEGORIES</b></span></li>
                            <?php foreach ($menu as $menu_item): ?>
                                <?php if ($menu_item['id'] != Category::getIdByAlias('featured')): ?>
                                    <?php if (count($menu_item['items'])): ?>
                                        <li style="text-transform: capitalize; padding-top: 5px;">
                                            <a href='#'><span><?= $menu_item['name'] ?></span></a>
                                            <ul style="list-style: none; padding-left: 20px;" <?= empty($s_subcategory) ? 'class="non-enbl-sb-open"' : (strtolower($menu_item['name']) == $s_category ? 'class="enbl-sb-open"' : 'class="non-enbl-sb-open"') ?>>
                                                <?php foreach ($menu_item['items'] as $child): ?>
                                                    <li style="padding-top: 5px;">
                                                        <a class="tools-lnk" href='<?= !empty($s_brand) ? '/designers/' . $s_brand . $child['url'] : $child['url'] ?>' <?= trim($s_subcategory) == str_replace(' ', '-', strtolower($child['name'])) || trim($s_subcategory) == strtolower($child['name']) ? 'style="text-decoration: underline;"' : '' ?>><span><?= $child['name'] ?></span></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php else: ?>
                                        <li style="text-transform: capitalize; padding-top: 5px;">
                                            <a href='<?= $menu_item['url'] ?><?= !empty($s_brand) ? '/' . $s_brand : '' ?>'><span><?= $menu_item['name'] ?></span></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><span><b>DESIGNERS</b></span>
                                <ul style="list-style: none; padding-left: 0; margin-top:20px;" class="design">
                                    <li><input type="text" data-category="<?= $s_category ?>" data-sub-category="<?= $s_subcategory ?>" id="search-text-design-filter" name="search-text" class="search-input-normal" maxlength="50"/ placeholder="Search by designer"></li>
                                    <?php foreach ($brands as $brand): ?>
                                        <li style="padding-top: 5px;">
                                            <a class="tools-lnk" href="/<?= !empty($s_subcategory) ? $s_category . '/' . str_replace(' ', '-', trim($s_subcategory)) . '/designers' : 'designers' ?>/<?= $brand->url ?>" <?= $s_brand == $brand->url ? 'style="text-decoration: underline;"' : '' ?>><span><?= $brand->name ?></span></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="close-menu">
            <a href="javascript:void(0)" class="close-tools-lnk">Cancel</a>
        </div>
    </div>
</div>

<!--MAIN BLOCK-->
<div class="uk-block uk-margin-large-top">
    <div class="uk-container uk-container-center" style="max-width: 95%;">
        <!--HEADERS-->
        <div class="uk-text-center">
            <?php if (!empty($model)): ?>
                <?php if (get_class($model) == 'Category') : ?>
                    <div>
                        <?php
                        if (isset($model->parent) && $model->parent) {
                            $parent = $model->parent->getNameByLanguage();
                        } else {
                            $parent = $model->getNameByLanguage();
                        }
                        ?> <h1 class="this-is-header"> <?php
                        echo (!empty($s_brand_title) ? $s_brand_title . '&nbsp;' : '') . ($model->getNameByLanguage()->header_text ? CHtml::encode($model->getNameByLanguage()->header_text) : CHtml::encode($parent->name))  ?></h1>

                    </div>
                    <!-- <div class="uk-h1"><?//php echo ($parent->name == $model->getNameByLanguage()->name) ? 'all' : CHtml::encode(strtolower($model->getNameByLanguage()->name)) ?></div> -->
<!--                    <h1 class="this-is-header">--><?php //echo ($parent->name == $model->getNameByLanguage()->name) ? 'all' : CHtml::encode(strtolower($model->getNameByLanguage()->name)) ?><!--</h1>-->
                <?php else : ?>
                    <!-- <div class="uk-h1"><?//php echo CHtml::encode($model->name) ?></div> -->
                    <h1 class="this-is-header"><?php echo CHtml::encode($model->name) ?></h1>
                <?php endif; ?>
            <?php else : ?>
                <!-- <div class="uk-h1"><?//= Yii::t('base', 'Shop') ?></div>   --> 
                <h1 class="this-is-header"><?= Yii::t('base', 'Shop') ?></h1> 
            <?php endif; ?>
        </div>
        <!--END HEADERS-->

        <div id='products'>
            <?php $this->renderPartial('_products_form',
                array(
                    'model' => $model,
                    'products' => $products,
                    'pages' => $pages,
                    'filters' => $filters,
                    's_category' => $s_category,
                    's_subcategory' => $s_subcategory,
                    's_brand' => $s_brand,
                    'brands_all' => $brands_all,
                    'alphabet' => $alphabet,
                    'currency' => $currency,
                    'columnsCount' => $columnsCount,
                )
            ); ?>
        </div>

    </div>
</div>
<!--END MAIN BLOCK-->
<?php if (!isset($_GET['sort'])): ?>
<script>
    jQuery(document).ready(function($) {
        //$('#sort').val('').trigger('change');
    });
</script>
<?php endif; ?>
<!--LazyLoad-->
<script src="<?=Yii::app()->request->baseUrl?>/js/jquery/jquery.lazyload.min.js"></script>

<script>
    $('.close-tools-lnk').click(function () {
        $('.mbl-tools-sort').hide();
        $('.mbl-tools-filter').hide();
    });
    
    $('.sort-lnk-mbl').click(function () {
        $('.mbl-tools-sort').hide();
        var sortOrder = $(this).attr('data-sort');
        $.ajax({
            type: "GET",
            data: {sort: sortOrder, mbl: 1},
            success: function (data) {
                $('#products').html(data);
            }
        })
    });
</script>