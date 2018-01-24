<?php

/**
 * This is the model class for table "paypal_log".
 *
* @property integer $id
 * @property string $value
 */
class PaypalLog extends CActiveRecord
{
    public $value;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'paypal_log';
    }

    public static function log($data)
    {
        $log = new self();
        $log->value = print_r($data, true);
        $log->save();
    }
}