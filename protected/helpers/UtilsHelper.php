<?php

/**
 * Utilites class
 */
class UtilsHelper
{
    /**
     * @param array $arr .
     * @return array.
     */
    public static function byAlphabetCat($arr = array())
    {
        if (count($arr)) {
            $tmp = array();
            $alphabet = self::getAlphabet();
            natsort($arr);
            foreach ($arr as $item) {
                $key = strtolower(mb_substr($item, 0, 1));
                if (!in_array($key, $alphabet)) {
                    $key = '#';
                }
                if (!isset($tmp[$key])) {
                    $tmp[$key] = array();
                }
                $tmp[$key][] = $item;
            }
            $arr = $tmp;
        }
        return $arr;
    }

    /**
     * @param array $extra .
     * @return array.
     */
    public static function getAlphabet($extra = array())
    {
        $alphabet = range('a', 'z');
        if (count($extra)) {
            $alphabet = array_merge($alphabet, $extra);
        }
        natsort($alphabet);
        return $alphabet;
    }

    /**
     * Convert std Object info array
     *
     * @param stdObject $d
     * @return array
     */
    public static function objectToArray($d)
    {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(array('UtilsHelper', 'objectToArray'), $d);
        } else {
            // Return array
            return $d;
        }
    }

    /**
     * Convert XML object into array
     *
     * @param SimpleXMLElement $xml
     * @param array $namespaces
     * @return array
     */
    public static function xmlToArray($xml, $namespaces = null)
    {
        $iter = 0;
        $arr = array();

        if (is_string($xml))
            $xml = new SimpleXMLElement($xml);

        if (!($xml instanceof SimpleXMLElement))
            return $arr;

        if ($namespaces === null)
            $namespaces = $xml->getDocNamespaces(true);

        foreach ($xml->attributes() as $attributeName => $attributeValue) {
            $arr["_attributes"][$attributeName] = trim($attributeValue);
        }
        foreach ($namespaces as $namespace_prefix => $namespace_name) {
            foreach ($xml->attributes($namespace_prefix, true) as $attributeName => $attributeValue) {
                $arr["_attributes"][$namespace_prefix . ':' . $attributeName] = trim($attributeValue);
            }
        }
        $has_children = false;
        foreach ($xml->children() as $element) {
            /** @var $element SimpleXMLElement */
            $has_children = true;
            $elementName = $element->getName();
            if ($element->children()) {
                $arr[$elementName][] = self::xmlToArray($element, $namespaces);
            } else {
                $shouldCreateArray = array_key_exists($elementName, $arr) && !is_array($arr[$elementName]);

                if ($shouldCreateArray) {
                    $arr[$elementName] = array($arr[$elementName]);
                }

                $shouldAddValueToArray = array_key_exists($elementName, $arr) && is_array($arr[$elementName]);

                if ($shouldAddValueToArray) {
                    $arr[$elementName][] = trim($element[0]);
                } else {
                    $arr[$elementName] = trim($element[0]);
                }
            }
            $iter++;
        }
        if (!$has_children) {
            $arr['_contents'] = trim($xml[0]);
        }
        return $arr;
    }

    /**
     * Format file size into human-readable value
     *
     * @param int $bytes
     * @param int $precision
     */
    public static function bytesToSize($bytes, $precision = 2)
    {
        // human readable format -- powers of 1024
        //
        $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision) . ' ' . $unit[$i];
    }

    /**
     * Format number value with commas
     *
     * @param mixed $value
     */
    public static function formatNumber($value)
    {
        $length = strlen((string)$value);
        $result = '';
        $k = 0;
        for ($i = $length - 1; $i >= 0; $i--) {
            if ($k == 3) {
                $result = ',' . $result;
                $k = 0;
            }
            $result = $value[$i] . $result;
            $k++;
        }
        return $result;
    }

    public static function generateRandomString($length = 5, $digitsOnly = false)
    {
        $string = '0123456789';
        if (!$digitsOnly)
            $string .= 'abcdefghijklmnopqrstuvwxuz';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $string[mt_rand(0, strlen($string) - 1)];
        }
        return $result;
    }

    public static function verifyEmail($email)
    {
        $validator = new CEmailValidator();
        return $validator->validateValue($email);
    }

    public static function isValidProductPrice(Product $product)
    {
        $dbProduct = Product::model()->findByPk($product->id);

        if (!count($dbProduct)) return false;

        if ($dbProduct->status != Product::PRODUCT_STATUS_ACTIVE) return false;

        if ($dbProduct->price === $product->price) { // ------ without personal discount
            return true;
        } else {
            $offers = Offers::model()->findAll('user_id=:user_id AND product_id=:product_id', array(
                ':user_id' => Yii::app()->member->id,
                ':product_id' => $product->id
            ));

            if (!count($offers)) return false;

            foreach($offers as $offer) {

                if ((int)$offer->confirm !== 1) continue;

                if ($offer->offer === $product->price) return true;
            }
        }

        return false;
    }

    public static function getLanguages()
    {
        return array('en', 'de'/*, 'ru'*/);
    }

    public static function getArLanguages()
    {
        return array('en' => 'en', 'de' => 'de', 'ru' => 'ru');
    }

    public static function getAllowCountries($category_id = null)
    {
        $list = array('England' => 'England', 'France' => 'France', 'Germany' => 'Germany', 'Spain' => 'Spain', 'Portugal' => 'Portugal');
        return $list;
    }

    public static function addParams($section, $param, $value)
    {

        // Путь к файлу конфигурации.
        $cpath = Yii:: app()->getBasePath() . '/config/params/' . $section . '.php';

        // Сохраняем параметр в конфиг.
        $config = new CConfiguration($cpath);
        if (is_array($param)) {
            foreach ($param as $k => $v) {
                $config->mergeWith(array($k => $v));
            }
        } else {
            $config->mergeWith(array($param => $value));
        }

        // Сохраняем конфигурацию в файл.
        $content = "<?php return " . ($config->saveAsString()) . ";?>";
        file_put_contents($cpath, $content, LOCK_EX);

    }

    public static function writeConditionSettings($section, $param, $value)
    {
        // Путь к файлу конфигурации.
        $cpath = Yii:: app()->getBasePath() . '/config/params/' . $section . '.php';

        $data = "array ('" . $param . "' => array(";
        for ($i = 1; $i <= count($value); $i++) {
            if (!empty($value[$i - 1])) {
                $data .= "$i => Yii::t('base', '" . trim($value[$i - 1]) . "'),";
            }
        }
        $data .= "))";
        // Сохраняем конфигурацию в файл.
        $content = "<?php return " . $data . ";?>";
        file_put_contents($cpath, $content, LOCK_EX);
    }

    public static function rmDir($path)
    {
        if (is_dir($path)) {
            $arr = glob($path . "/*");
            if ($arr !== false) {
                foreach ($arr as $filename) {
                    if (is_dir($filename)) {
                        if (!self::rmDir($filename)) return false;
                    } else {
                        if (!@unlink($filename)) return false;
                    }
                }
            }
            if (!@rmdir($path)) {
                return false;
            }
        }
        return true;
    }

    public static function getTopMenu()
    {
        $menu = array();

        $menu['account'] = array(
            'name' => Yii::t('base', 'Account'),
            //'url' => '/my-account/items',
            'url' => '/my-account/settings',
            'visible' => !Yii::app()->member->isGuest
        );
        
        $menu['wishlist'] = array(
            'name' => Yii::t('base', 'Wishlist'),
            //'url' => '/my-account/items',
            'url' => '/my-account/wishlist',
        );

        $menu['login'] = array(
            'name' => Yii::t('base', 'Account'),
            'url' => '/members/auth/login',
            'visible' => Yii::app()->member->isGuest
        );

        $menu['bag'] = array(
            'name' => Yii::t('base', 'Bag'),
            'url' => '#',
            'count' => Yii::app()->shoppingCart->getCount()
        );

        $menu['search'] = array(
            'name' => Yii::t('base', 'Search'),
            'url' => '#search'
        );
        
        $menu['logout'] = array(
            'name' => Yii::t('base', 'Logout') . ' (' .
                CHtml::encode((!Yii::app()->member->isGuest ? Yii::app()->member->username : Yii::app()->member->guestName)) .
                ')',
            'url' => '/members/auth/logout',
            'visible' => !Yii::app()->member->isGuest

        );

        return $menu;
    }

    public static function getSelectedItemName()
    {
        $url = Yii::app()->request->getUrl();
        $urlArr = explode('/', $url);
        $len = count($urlArr);
        $parent = '';
        $selectedItemName = '';

        if (isset($urlArr[2])) {
            $parent = $urlArr[2];
        }

        switch ($parent) {
            case 'category': {
                $selectedItemName =
                    isset($urlArr[$len - 2]) ? $urlArr[$len - 2] : '';
                break;
            }
            case 'product' : {
                $selectedItemName =
                    isset($urlArr[3]) ? $urlArr[3] : '';
                break;
            }
            case 'brands' : {
                $selectedItemName = $parent;
                break;
            }
            default : {
                $selectedItemName =
                    isset($urlArr[$len - 1]) ? $urlArr[$len - 1] : '';
                break;
            }
        }

        return $selectedItemName;
    }

    public static function getSelectedChildName()
    {
        $url = Yii::app()->request->getUrl();
        $urlArr = explode('/', $url);
        return end($urlArr);
    }

    public static function getCategoryMenu($brand = "")
    {
        $menu = array();
        $sql = 'SELECT * FROM `category` WHERE `category`.status != "inactive" ORDER BY `category`.`menu_order` ASC ';
        $items = Category::model()->findAllBySql($sql);
        $counter = 0;
        $selectedName = self::getSelectedItemName();
        $selectedChildName = self::getSelectedChildName();

        foreach ($items as $item) {
            if ($item['parent_id'] === null && $item['status'] == 'active') {
                $menu[$counter] = array();
                $menu[$counter]['id'] = $item['id'];
                $menu[$counter]['name'] = $item['alias'];
                $menu[$counter]['selected'] = false;
                //$menu[$counter]['url'] = '/shop/' . strtolower($item['alias']) . '-all';
                $menu[$counter]['url'] = '/' . strtolower($item['alias']);

                if ($item['alias'] == $selectedName) {
                    $menu[$counter]['selected'] = true;
                }

                $menu[$counter]['items'] = array();

                foreach ($items as $child) {
                    if ($child['parent_id'] == $item['id']) {
                        $child_data = array();

                        $child_data['id'] = $child['id'];
                        $child_data['name'] = $child['alias'];
                        $childAliasWithoutSpaces = str_replace(' ', '-', $child['alias']);
//                        $child_data['url'] =
//                            '/shop/' . strtolower($item['alias']) . '-' . strtolower($childAliasWithoutSpaces);
                        $child_data['url'] =
                              '/' . strtolower($item['alias']) . '/' . strtolower($childAliasWithoutSpaces);
                        $child_data['selected'] = false;

                        if ($selectedChildName) {
                            if ($child['alias'] == $selectedChildName) {
                                $child_data['selected'] = true;
                            }
                        }

                        array_push($menu[$counter]['items'], $child_data);
                    }
                }

                $counter++;
            }
        }

        if (!empty($brand)) {
            $brand_db = Brand::model()->findByAttributes(['url' => $brand]);
            if ($brand_db) {
                foreach ($menu as $key => &$item) {
                    if ($item['id'] != Category::getIdByAlias('featured')) {
                        $item_invis = 0;
                        $cnt = count($item['items']);
                        foreach ($item['items'] as $k => &$child) {
                            if (!Product::model()->exists('category_id = :cat AND brand_id = :brand', [':cat' => $child['id'], ':brand' => $brand_db->id])) {
                                unset($item['items'][$k]);
                                $item_invis ++;
                            }
                        }
                        if ($cnt == $item_invis) {
                            if (!Product::model()->exists('category_id = :cat AND brand_id = :brand', [':cat' => $item['id'], ':brand' => $brand_db->id])) {
                                unset($menu[$key]);
                            }
                        }
                    }
                }
            }
        }
        
        return $menu;
    }

    public static function getSecondMenu()
    {
        $selectedName = self::getSelectedItemName();

        $links = array(
            array(
                'name' => Yii::t('base', 'Editorial'),
                'key' => 'blog',
                'url' => Yii::app()->params['misc']['blog_url'],
                'selected' => false
            ),
            array(
                'name' => Yii::t('base', 'Designers'),
                'key' => 'brands',
                //'url' => '/shop/all-brands',
                'url' => '/all-brands',
                'selected' => false
            ),
            
//            array(
//                'name' => Yii::t('base', 'About'),
//                'key' => 'about',
//                //'url' => '/page/about',
//                'url' => '/about',
//                'selected' => false
//            ),
//            array(
//                'name' => Yii::t('base', 'Sell'),
//                'key' => 'sell',
//                'url' => '/sell-online',
//                'selected' => false
//            ),
        );

        $criteria = new CDbCriteria();
        $criteria->addCondition('footer_order > 0');
        $criteria->addCondition('status = "active"');
        $criteria->addCondition('position =' . Page::POSITION_MENU . ' OR position=' . Page::POSITION_FOOTER_AND_MENU);
        $criteria->order = 'footer_order';
        /*$menu = Page::model()->findAll($criteria);
        foreach ($menu as $page) {
            array_push($links, array(
                'name' => $page->page_title,
                'key' => $page->page_title,
                //'url' => ('/page/' . $page->slug),
                'url' => ('/' . $page->slug),
                'selected' => false
            ));
        }*/

        foreach ($links as &$link) {
            if ($link['key'] == $selectedName) {
                $link['selected'] = true;
            }
        }

        return $links;
    }

    public static function getNavProfileMenu($public = false)
    {
        $uid = isset($_GET['id']) ? $_GET['id'] : Yii::app()->member->id;
        $profileLink = ($uid == Yii::app()->member->id) ? '/my-account' : '/profile-' . $uid;

        $menu = array(
            'items' => array(
//                'items' => array(
//                    'id' => 'items',
//                    'label' => Yii::t('base', 'My items'),
//                    'url' => $profileLink . '/items',
//                    'active' => (stripos(Yii::app()->request->url, $profileLink . '/items')) !== false,
//                    'visible' => true
//                ),

                'history' => array(
                    'id' => 'history',
                    'label' => Yii::t('base', 'History'),
                    'url' => $profileLink . '/history',
                    'active' => (stripos(Yii::app()->request->url, $profileLink . '/history')) !== false,
                    'visible' => ($public) ? false : true
                ),

                'wishlist' => array(
                    'id' => 'wishlist',
                    'label' => Yii::t('base', 'Wishlist'),
                    'url' => $profileLink . '/wishlist',
                    'active' => (stripos(Yii::app()->request->url, $profileLink . '/wishlist')) !== false,
                    'visible' => true
                ),

                'settings' => array(
                    'id' => 'settings',
                    'label' => Yii::t('base', 'Settings'),
                    'url' => $profileLink . '/settings',
                    'active' => (stripos(Yii::app()->request->url, $profileLink . '/settings')) !== false,
                    'visible' => ($public) ? false : true
                ),

//                'alerts' => array(
//                    'id' => 'alerts',
//                    'label' => Yii::t('base', 'Alerts'),
//                    'url' => $profileLink . '/alerts',
//                    'active' => ((stripos(Yii::app()->request->url, $profileLink . '/alerts') !== false) ||
//                            stripos(Yii::app()->request->url, 'alertsUpdate')) !== false,
//                    'visible' => true
//                ),
//
//                'inbox' => array(
//                    'id' => 'inbox',
//                    'label' => Yii::t('base', 'Inbox'),
//                    'url' => $profileLink . '/inbox',
//                    'active' => (stripos(Yii::app()->request->url, $profileLink . '/inbox')) !== false,
//                    'visible' => ($public) ? false : true
//                )
            )
        );

        return $menu;
    }

    public static function getMenuByCategory($category = null, $all_child = false)
    {
        $list_subcat = array();

        if ($all_child and !$category) {
            $list_subcat = Category::model()->findAll('parent_id IS NOT NULL');
        } else {
            $list_subcat = Category::model()->findAll('parent_id = :parent_id', array(':parent_id' => $category));
        }

        $menu = array();
        $active = false;

        $menu['htmlOptions'] = array('class' => 'nav');
        $menu['activateItems'] = true;
        $menu['encodeLabel'] = false;
        $menu['items'] = array();

        foreach ($list_subcat as $key => $sub_cat) {
            $active = stripos(Yii::app()->request->url, $sub_cat->parent->alias . '/' . $sub_cat->alias);
            $menu['items'][$key]['label'] = $sub_cat->getNameByLanguage()->name;
            $menu['items'][$key]['url'] = array('/category/' . $sub_cat->parent->alias . '/' . $sub_cat->alias);
            $menu['items'][$key]['active'] = $active !== false;
            $menu['items'][$key]['linkOptions'] = array('parent' => $sub_cat->parent_id);
        }

        return $menu;
    }

    public static function getMenuByBrand()
    {
        $brands = Brand::model()->findAll();
        $menu = array();
        $active = false;

        $menu['htmlOptions'] = array('class' => 'nav');
        $menu['activateItems'] = true;
        $menu['encodeLabel'] = false;
        $menu['items'] = array();

        foreach ($brands as $key => $brand) {
            $active = stripos(Yii::app()->request->url, '/brands/' . $brand->name);
            $menu['items'][$key]['label'] = $brand->name;
            $menu['items'][$key]['url'] = array('/brands/' . $brand->name);
            $menu['items'][$key]['active'] = $active !== false;
        }

        return $menu;
    }

    public static function getLinkForChangeLang($lang)
    {
        Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
        $splitPath = explode('/', Yii::app()->request->url);
        if (in_array($splitPath[1], self::getLanguages())) {
            $splitPath[1] = $lang;
        } else {
            array_splice($splitPath, 1, 0, $lang);
        }

        return Yii::app()->createAbsoluteUrl(implode('/', $splitPath));
    }

    public static function getLeftFooterLinks($lang = 'en')
    {
        $menu = array();
        $criteria = new CDbCriteria();
        $criteria->addCondition('footer_order > 0');
        $criteria->addCondition('status = "active"');
        $criteria->addCondition('position =' . Page::POSITION_FOOTER . ' OR position=' . Page::POSITION_FOOTER_AND_MENU);
        $criteria->order = 'footer_order';
        $criteria->limit = 2;
        $leftmenu = Page::model()->findAll($criteria);
        foreach ($leftmenu as $page) {
            $menu[$page->page_title] = $page->slug;
        }
        return $menu;
    }

    public static function getRightFooterLinks($lang = 'en')
    {
        $menu = array();
        $criteria = new CDbCriteria();
        $criteria->addCondition('footer_order > 0');
        $criteria->addCondition('status = "active"');
        $criteria->addCondition('position =' . Page::POSITION_FOOTER . ' OR position=' . Page::POSITION_FOOTER_AND_MENU);
        $criteria->order = 'footer_order';
        $criteria->limit = 200;
        $criteria->offset = 2;
        $leftmenu = Page::model()->findAll($criteria);
        $i = 0;
        foreach ($leftmenu as $page) {
            $menu[$i]['title'] = $page->page_title;
            $menu[$i]['slug'] = $page->slug;
            $i++;
        }
        return $menu;
    }

    public static function getTermsAndConditionsHtml($lang = 'en')
    {
        $html = '';
        $title = '';

        $pageContent = PageContent::model()->with(array(
            'page' => array(
                'select' => false,
                'joinType' => 'INNER JOIN',
                'condition' => 'LOWER(page.slug)="terms" AND language=:lang',
                'params' => array(
                    ':lang' => $lang
                )
            ),
        ))->find();

        if ($pageContent) {
            $html = $pageContent->content;
            $title = $pageContent->title;
        }

        return array($title, $html);
    }

    public static function getTermsAndConditionsLink($lang = 'en')
    {
        $link = '/';

        $page = Page::model()->find(array(
            'select' => 'slug',
            'condition' => 'LOWER(slug)="terms"',
        ));
        if ($page) {
            //$link = '/page/' . $page->slug;
            $link = '/' . $page->slug;
        }

        return $link;
    }

    public static function getPrivacyLink($lang = 'en')
    {
        $link = '/';

        $page = Page::model()->find(array(
            'select' => 'slug',
            'condition' => 'LOWER(slug) LIKE "%privacy%"',
        ));
        if ($page) {
            //$link = '/page/' . $page->slug;
            $link = '/' . $page->slug;
        }

        return $link;
    }

    public static function getCookieLink($lang = 'en')
    {
        return self::getPrivacyLink();
    }
}