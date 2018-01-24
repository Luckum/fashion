<?php //echo "<pre>";print_r($model);die(); ?>

<div id="subcatmenu" class="navbar">
    <div class="navbar-inner">
        <div style="display: inline-block;">
            <?php
                $this->widget('zii.widgets.CMenu', UtilsHelper::getMenuByCategory(null, true));
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    var MenuManager = {
        firstMenuId : '#yw1',
        subMenuId : '#yw3',
        selectedItemId : 'selected-menu-item-link',
        parent_attr : 'self_id',
        child_attr : 'parent',

        main: function(){
            MenuManager.showSelectedChildren();
            MenuManager.setClickOptionToFirstMenuLinks();
        },

        getFirstMenuLinks: function () {
            var selector = MenuManager.firstMenuId + ' > li > a';
            return $(selector);
        },

        getSubMenuLinks: function () {
            var selector = MenuManager.subMenuId + ' > li > a';
            return $(selector);
        },

        unSelectFirstMenuItem: function () {
            var selector = '#' + MenuManager.selectedItemId;
            var item = $(selector);
            $(item).removeAttr('id');
        },

        setClickOptionToFirstMenuLinks: function () {
            var items = MenuManager.getFirstMenuLinks();

            for (var i = 0; i < items.length; i++) {
                $(items[i]).click(function (e) {
                    MenuManager.unSelectFirstMenuItem();
                    var link = e.target;
                    $(link).attr('id', MenuManager.selectedItemId);

                    MenuManager.showSelectedChildren();

                    return false;
                });
            }
        },

        showSelectedChildren : function(){
            var selector = '#' + MenuManager.selectedItemId;
            var parent = $(selector);
            var parent_id = $(parent[0]).attr(MenuManager.parent_attr);
            var subLinks = MenuManager.getSubMenuLinks();

            for(var i = 0; i < subLinks.length; i++){
                var subLink = subLinks[i];
                var subLink_parent_id = $(subLink).attr(MenuManager.child_attr);

                if(subLink_parent_id == parent_id){
                    $(subLink).show();
                }else{
                    $(subLink).hide();
                }
            }
        }

    };

    MenuManager.main();

</script>


