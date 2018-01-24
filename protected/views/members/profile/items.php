<?php
/* @var $this ProfileController */

$this->breadcrumbs = array(
    'Client Area' => array('members/index'),
    'Account Items' => '',
);
?>

<?php $this->widget('application.components.ModalFlash', array(
    'acceptableFlashes' => array('payment_info', 'product_update')
)); ?>

<!--ACCOUNT BLOCK-->
<div class="uk-block uk-block-large uk-margin-top">
    <div class="uk-container uk-container-center">
        <div class="uk-accordion account-wrapper" data-uk-accordion='{showfirst: true, animate: false}'>
            <div class="uk-grid">
                <div class="uk-width-large-7-10 uk-width-medium-7-10 uk-width-small-1-1">
                    <div class="uk-grid">
                        <!--PROFILE NAV-->
                        <?php $this->renderPartial('_profile_nav', array('showProfile' => (isset($showProfile) ? true : false))); ?>
                        <!--END PROFILE NAV-->
                        <!--SALE ITEMS-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
                            <div id="sale_items">
                                <?php $this->renderPartial('_sale_items', array('model' => $model, 'userId' => $userId)); ?>
                            </div>
                        </div>
                        <!--END SALE ITEMS-->
                    </div>
                </div>
                <!--PROFILE INFO-->
                <div
                    class="uk-width-1-1 uk-width-large-3-10 uk-width-medium-3-10 uk-width-small-1-1 margin-top-small-screen">
                    <?php $this->renderPartial('_nav_info', array('user' => $user)); ?>
                </div>
                <!--END PROFILE INFO-->
            </div>
        </div>
    </div>
</div>
<!--END ACCOUNT BLOCK-->

<!--MODAL ACCEPT OFFER-->
<div id="div-delete-item-modal"></div>
<!--END MODAL ACCEPT OFFER-->

<script>
    $(document).ready(function() {
        /**
         * Меняем цвет текста ссылок в зависимости от цвета фона изображения под ними.
         */
        /*$('.thumbnail-image img').each(function() {

            // Исходные размеры изображения.
            var imgh = this.naturalHeight;
            var imgw = this.naturalWidth;

            // Ссылки, которые необходимо цветоопределить.
            var root = $(this).closest('.thumbnail');
            var edit = root.find('.edit > a');

            // Позиция ссылок относительно контейнера.
            var diffx = edit.offset().left - root.offset().left;
            var diffy = edit.offset().top  - root.offset().top;

            try {

                // Холст.
                var container = $('<canvas/>').attr({
                    'height' : imgh,
                    'width'  : imgw
                });
                var context = container
                    .get(0)
                    .getContext('2d');

                // Наносим изображение на холст.
                context.drawImage(this, 0, 0);

                // Получаем цветовые характеристики пикселя в указанной позиции.
                var pixel = context.getImageData(diffx, diffy, 1, 1).data;
                var r = pixel[0];
                var g = pixel[1];
                var b = pixel[2];

                var color =  (r * 0.299 + g * 0.587 + b * 0.114) > 186 ?
                    '#000' : '#fff';

                // Инвертируем цвет пикселя.
                //r = 255 - r;
                //g = 255 - g;
                //b = 255 - b;

                // Устанавливаем цвет текста ссылок согласно полученному значению.
                //var hex = '#' + ((1 << 24) + (r << 16) + (g << 8) + b)
                //        .toString(16)
                //        .slice(1);

                edit
                    .css('color', color)
                    .parent()
                    .next()
                    .find('a')
                    .css('color', color);

            } catch (e) {
            }

        });*/
    });
</script>

