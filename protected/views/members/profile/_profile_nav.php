<?php
$menu = array();

if ((isset($_GET['id']) && $_GET['id'] == Yii::app()->member->id) || stripos(Yii::app()->request->url, 'my-account')) {
    $menu = UtilsHelper::getNavProfileMenu();
}

?>

<div class="uk-width-1-4 uk-visible-large">
    <?php
    if(!empty($menu)) {
        foreach ($menu['items'] as $item) {
            if ($item['visible']): ?>

                <a href="<?php echo $item['url']; ?>">
                    <div class="accordion-title"
                         style="<?php echo $item['active'] ?
                             'background-color: #000; color: #fff;' :
                             'background-color: #fff; color: #000;'; ?>">
                        <?php echo CHtml::encode($item['label']); ?>
                        <span class="uk-margin-left uk-text-danger" id="<?php echo $item['id']; ?>-menu-item"></span>
                    </div>
                </a>

                <?php
            endif;
        }
    }
    ?>
</div>

<div class="uk-width-1-1 uk-hidden-large uk-margin-bottom">
    <?php
    if(!empty($menu)) {
        foreach ($menu['items'] as $item) {
            if ($item['visible']): ?>

                <a href="<?php echo $item['url']; ?>">
                    <div class="accordion-title"
                         style="<?php echo $item['active'] ?
                             'background-color: #000; color: #fff;' :
                             'background-color: #fff; color: #000;'; ?>">
                        <?php echo CHtml::encode($item['label']); ?>
                    </div>
                </a>

                <?php
            endif;
        }
    }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var inbox_span = $('#inbox-menu-item');
        var html = '<?php echo ProfileController::getUnreadInfoText(); ?>';

        $(inbox_span).html(html);
    });
</script>
















