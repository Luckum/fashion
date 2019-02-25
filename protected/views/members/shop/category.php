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


