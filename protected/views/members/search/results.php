<div class="uk-block uk-margin-large-top">
    <div class="uk-container uk-container-center">
        <div class="uk-h1 uk-text-center"><?=Yii::t('base', 'Search results for') . ' ' . "'$q'" ?></div>
    </div>
</div>
<hr style="border-top: 2px solid #000;">
<div class="uk-block uk-text-line-height">
    <div class="uk-grid uk-grid-width-large-1-3">
        <div>
            <ul style="list-style: none; font-size: 16px;">
                <li style="text-transform: uppercase; margin-bottom: 15px;">Products</li>
                <?php foreach ($products as $product): ?>
                    <?php
                        $parent = Category::model()->findByPk($product->category->parent_id);
                        $cat_name = $parent ? $parent->alias . '/' . $product->category->alias : $product->category->alias;
                    ?>
                    <li><a href="<?= strtolower(str_replace(' ', '-', '/' . $cat_name . '/' . trim($product->title) . '-' . $product->id)) ?>"><?= $product->title ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <ul style="list-style: none; font-size: 16px;">
                <li style="text-transform: uppercase; margin-bottom: 15px;">Designers</li>
                <?php foreach ($brands as $brand): ?>
                    <li><a href="<?= '/designers/' . $brand->url ?>"><?= $brand->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <ul style="list-style: none; font-size: 16px;">
                <li style="text-transform: uppercase; margin-bottom: 15px;">Categories</li>
                <?php foreach ($categories as $category): ?>
                    <?php $parent = Category::model()->findByPk($category->parent_id); ?>
                    <li><a href="<?= $parent ? strtolower(str_replace(' ', '-', '/' . $parent->alias . '/' . $category->alias)) : strtolower(str_replace(' ', '-', '/' . $category->alias)) ?>"><?= $category->alias . ($parent ? ' (' . $parent->alias . ')' : '') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>