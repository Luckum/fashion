<?php

/**
 * This is the model class for table "brand_variant".
 *
 * The followings are the available columns in table 'brand_variant':
 * @property integer $id
 * @property integer $brand_id
 * @property string $name
 * @property string $url
 *
 * The followings are the available model relations:
 * @property Brand $brand
 */
class BrandVariant extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{brand_variant}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required', 'message' => '*required'),
            array('name, url', 'length', 'max'=>255),
            array('brand_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, brand_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'brand'   => array(self::BELONGS_TO, 'Brand', 'brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'name' => Yii::t('base', 'Brand Name'),
            'brand_id' => Yii::t('base', 'Brand ID'),
            'url' => Yii::t('base', 'Brand URL'),
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}