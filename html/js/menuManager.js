
var MenuManager = {
    mainMenuWrapperId: 'menu-centered',
    subMenuWrapperId: 'subcatmenu',
    selectedItemId: 'selected-menu-item-link',
    parent_attr: 'self_id',
    child_attr: 'parent',

    main: function () {
        MenuManager.showSelectedChildren();
        MenuManager.setClickOptionToFirstMenuLinks();
    },

    getFirstMenuLinks: function () {
        var menu = $('#' + MenuManager.mainMenuWrapperId);
        if (!menu.length) {
            return false;
        }
        var menu_id = menu[0].firstElementChild.id;

        return $('#' + menu_id + ' > li > a');
    },

    getSubMenuLinks: function () {
        var menu_id =
            $('#' + MenuManager.subMenuWrapperId)[0].
                firstElementChild.
                firstElementChild.
                firstElementChild.id;

        var links = $('#' + menu_id + ' > li > a');

        return links;
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

    showSelectedChildren: function () {
        var parent = $('#' + MenuManager.selectedItemId);
        var parent_id = $(parent[0]).attr(MenuManager.parent_attr);

        var subMenuWrap = '#' + MenuManager.subMenuWrapperId;

        if(typeof parent_id === 'undefined'){ // --- if it's not a category page
            $(subMenuWrap).hide();
            $(subMenuWrap).css('margin-bottom', 0);
            return;
        }else{
            $(subMenuWrap).show();
        }

        var subLinks = MenuManager.getSubMenuLinks();

        for (var i = 0; i < subLinks.length; i++) {
            var subLink = subLinks[i];
            var subLink_parent_id = $(subLink).attr(MenuManager.child_attr);

            if (subLink_parent_id == parent_id) {
                $(subLink).show();
            } else {
                $(subLink).hide();
            }
        }
    }

};

MenuManager.main();

