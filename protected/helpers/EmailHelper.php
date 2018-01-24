<?php

class EmailHelper
{
    // -------- fields for using
    //
    public static $userAllowedArray = array(
        'username',
        'email',
        'status',
        'registration_date'
    );

    public static $productAllowedArray = array(
        'title',
        'description',
        'color',
        'price',
        'init_price',
        'added_date',
        'status'
    );

    public static $sellerAllowedArray = array(
        'seller_type',
        'comission_rate',
        'paypal_email'
    );

    public static $offersAllowedArray = array(
        'added_date',
        'offer'
    );

    public static $orderItemAllowedArray = array(
        'price',
        'comission_rate',
        'tracking_number',
        'tracking_link',
    );

    public static $orderAllowedArray = array(
        'id',
        'added_date',
        'total',
        'status',
        'paypal_id',
        'shipping_cost'
    );

    public static $commentAllowedArray = array(
        'comment'
    );

    // --------- additional options
    //
    public static $additionalOptions = array(
        'Option' => array(
            'link'
        )
    );

    public static function example(){
//        $variables = EmailHelper::getKeys(array(
//            new User(),
//            new Product()
//        ), array(
//            'User' => EmailHelper::$userAllowedArray,
//            'Product' => EmailHelper::$productAllowedArray
//        ),
//            EmailHelper::$additionalOptions);

        // $variables was used in view and user wrote $string

        $string = 'Test text for{Product/title}debug of{User/email}using {Option/link} variables {Option/info}';
        $result = EmailHelper::setValues($string, array(
            User::model()->findByPk(27),
            Product::model()->findByPk(42),
            Order::model()->findByPk(5),
            array(
                'Option' => array(
                    'link' => 'http://some'
                )
            )
        ));

        var_dump($result);
    }

    /**
     * @param $objArray ------- array(new Class1(), new Class2())
     * @param $allowedArray --- array('Class1' => ('field1', .....))
     * @param $additionalOptions -- additional keys
     * @return array
     */
    public static function getKeys($objArray, $allowedArray, $additionalOptions = null)
    {
        $variables = array();

        foreach ($objArray as $obj) {
            if (!is_object($obj)) continue;

            $class_name = get_class($obj);

            $variables[$class_name] = array();

            foreach ($obj as $key => $value) {
                if (array_key_exists($class_name, $allowedArray)) {
                    if (in_array($key, $allowedArray[$class_name])) {
                        $variables[$class_name][$key] = "{{$class_name}/{$key}}";
                    }
                }
            }

            ksort($variables[$class_name]); // --- sort fields for using
        }

        if (is_array($additionalOptions)) {
            foreach ($additionalOptions as $key => $arr) {
                $variables[$key] = array();

                foreach ($arr as $index => $value) {
                    $variables[$key][$value] = "{{$key}/{$value}}";
                }

                ksort($variables[$key]);
            }
        }

        return $variables;
    }

    /**
     * @param $text
     * @param $valueArray --- like array($product, $user, array('Option' => array('link' => 'http://some', ..), ..))
     * @return array
     */
    public static function setValues($text, $valueArray){
        $keys = EmailHelper::getKeysArrayFromText($text);
        $result = EmailHelper::setSubstituteValues($keys, $valueArray);

        return $result;
    }

    private static function extractFieldNames($text)
    {
        preg_match_all('#\{[a-zA-Z0-9_\/]*\}#', $text, $result); // --- find like {User/id}

        return count($result) > 0 ? $result[0] : $result;
    }

    private static function formAssociativeArray($simpleArray)
    {
        // --- input like {Product/id} {User/id} {Brand/id} {Product/brand_id}

        $result = array();

        foreach ($simpleArray as $row) {
            $memory = $row;
            $row = str_replace(array('{', '}'), array('', ''), $row); // --- like '{Brand/id}' ---> 'Brand/id'
            $tempArray = explode('/', $row); // ------------- array like ('Brand', 'id')

            if (count($tempArray) < 2) continue;

            $class = $tempArray[0];
            $field = $tempArray[1];

            if (isset($result[$class])) {  // --------------- if exists array like ('Brand' => array())
                $result[$class][$field] = $memory;
            } else {
                $result[$class] = array($field => $memory);
            }
        }

        return $result; // ----------- like array('User' => array('id' => '{User/id}'), ...)
    }

    private static function getKeysArrayFromText($text){
        $simple = EmailHelper::extractFieldNames($text);
        $associative = EmailHelper::formAssociativeArray($simple);

        return $associative;
    }

    /**
     * @param $keyArray --- from EmailHelper::formAssociativeArray($simpleArray)
     * @param $valueArray --- like array($product, $user, array('Option' => array('link' => 'http://some', ..), ..))
     * @return array like array({Product/id} => 10, {User/email} => pupkin@mail.ru, ...)
     */
    private static function setSubstituteValues($keyArray, $valueArray)
    {
        $result = array();

        // ----------- for objects
        //
        foreach ($valueArray as $obj) {
            if (!is_object($obj)) continue;

            $className = get_class($obj);

            if (!isset($keyArray[$className])) continue; // --- nothing for this object

            foreach ($keyArray[$className] as $key => $value) {
                if (isset($obj->$key) && !isset($result[$value])) {
                    if($value == '{Product/title}') {
                        $result[$value] = strtoupper($obj->brand->name.' '.$obj->$key.' [#'.$obj->id.']');
                    } elseif($value == '{Product/added_date}') {
                        $result[$value] = date('Y-m-d H:i:s');
                    } else {
                        $result[$value] = $obj->$key; // ---------- like array('{User/user_id}' => 2222)
                    }
                }
                if($value == '{Order/shipping_to}') {
                        $state = (!empty($obj->shippingAddress->state)) ? $obj->shippingAddress->state . ', ' : '';
                        $result[$value] = $obj->shippingAddress->address . ', ' .
                            $state .
                            $obj->shippingAddress->city . ', ' .
                            $obj->shippingAddress->country->name . ', ' .
                            $obj->shippingAddress->zip;
                    }

            }
        }

        // ----------- for arrays like array('Option' => array('link' => 'http://some', ..), ....)
        //
        foreach ($valueArray as $arr) {
            if (!is_array($arr)) continue;

            foreach ($arr as $name => $values) {
                if (!isset($keyArray[$name])) continue; // --- nothing for this item of array

                foreach ($values as $key => $value) {
                    if (!isset($keyArray[$name][$key])) continue; // --- nothing for this property

                    $result[$keyArray[$name][$key]] = $value;
                }
            }
        }

        return $result;
    }
}


















