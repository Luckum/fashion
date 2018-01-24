<?php
class ShopUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $path = explode('/',$pathInfo);
        if(!empty($path) && $path[0] == 'blog') {
            $postName = str_replace('-', ' ', $path[1]);
            $blogPost = BlogPost::model()->find(array(
                'condition' => 'LOWER(title) = :slug',
                'params' => array('slug'=>$postName),
            ));
            if($blogPost !== NULL) {
                $_GET['id'] = $blogPost->getPrimaryKey();
                $_GET['name'] = $path[1];
                return "members/blog/post/".$blogPost->getPrimaryKey();
            }
        } elseif(!empty($path) && count($path) == 1) {
//            if($path[0] == 'all-brands') {
//                $_GET['category'] = 'all';
//                $_GET['subcategory'] = 'brands';
//                return "members/shop/showCategory/".$_GET['category']."-".$_GET['subcategory'];
//            }
            $nameWithTire = explode('-',$path[0]);
            $forPop = $nameWithTire;
            $page = Page::model()->find(array(
                'condition' => 'LOWER(slug) = :slug',
                'params' => array('slug'=>$path[0]),
            ));
            if ($page !== null) {
                $_GET['id'] = $page->getPrimaryKey();
                $_GET['slug'] = $page->slug;
                return "site/static/page/$page->slug";
            }
            if(count($nameWithTire) > 1) {
                $product = Product::model()->find(array(
                    'condition' => 'id = :id',
                    'params' => array('id'=>array_pop($forPop)),
                ));
                if($product !== null) {
                    $_GET['id'] = $product->getPrimaryKey();
                    $name = '';
                    for($i=0; $i<count($nameWithTire)-1; $i++) {
                        $name .= $nameWithTire[$i];
                    }
                    $_GET['name'] = $name;
                    return "members/shop/productDetails/".$product->getPrimaryKey();
                } elseif(count($nameWithTire) > 2) {
                    $categoryName = explode('-', $path[0], 2);
                    $subName = explode('-',$categoryName[1]);
                    $categoryName[1] = '';
                    for($i=0; $i<count($subName); $i++) {
                        if($subName[$i] == 't' && $subName[$i+1] == 'shirts') {
                            $categoryName[1] .= $subName[$i].'-';
                        } elseif($i==count($subName)) {
                            $categoryName[1] .= $subName[$i];
                        } else {
                            $categoryName[1] .= $subName[$i].' ';
                        }
                    }
                    $category = Category::model()->find(array(
                        'condition' => 'LOWER(alias) = :alias',
                        'params' => array('alias'=>$categoryName[1]),
                    ));
                    if($category !== null) {
                        $_GET['category'] = $categoryName[0];
                        $_GET['subcategory'] = $categoryName[1];
                        return "members/shop/showCategory/".$_GET['category']."-".$_GET['subcategory'];
                    }
                } elseif(count($nameWithTire) == 2) {
                    $_GET['category'] = $nameWithTire[0];
                    $_GET['subcategory'] = $nameWithTire[1];
                    return "members/shop/showCategory/".$_GET['category']."-".$_GET['subcategory'];
                }
            }
        }
        return false;
    }

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if(isset($params) && !empty($params)) {
            if ($route == 'members/blog/post/'.$params['id']) {
                return $params['name'];
            } elseif ($route == 'site/static/page/'.$params['slug']) {
                if (!empty($params['id'])) {
                    if ($page = Page::model()->findByPk($params['id'])) {
                        return $page->slug;
                    }
                }
            } elseif ($route == 'members/shop/productDetails/'.$params['id']) {
                return $params['name'];
            } elseif ($route == 'members/shop/showCategory/'.$params['category'].'-'.$params['subcategory']) {
                return $params['category'].'-'.$params['subcategory'];
            }
        }
        return false;
    }
}