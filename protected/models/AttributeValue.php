<?php

/**
 * This is the model class for table "attribute_values".
 *
 * The followings are the available columns in table 'attribute_values':
 * @property integer $id
 * @property string $language
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Attribute $attribute
 */
class AttributeValue extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{attribute_values}}';
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'group' => array(self::BELONGS_TO, 'AttributeValueGroup', 'group_id'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('language, value', 'required', 'message' => '*required'),
            array('group_id', 'safe'),
            array('language', 'length', 'max'=>2),
            array('value', 'length', 'max'=>512),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, group_id, language, value', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'language' => Yii::t('base', 'Language'),
            'value' => Yii::t('base', 'Value'),
            'group_id' => Yii::t('base', 'Group'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('group_id',$this->group_id);
        $criteria->compare('language',$this->language,true);
        $criteria->compare('value',$this->value,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AttributeName the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getValuesList($lang = 'en')
    {
        $result = array();
        $values = self::model()->findAllByAttributes(
            array(
                'language' => $lang
            )
        );

        if ($values) {
            foreach ($values as $value) {
                $result[$value->value] = $value->value;
            }
        }
        return $result;
    }

    public static function getValuesWithGroupsList($lang = 'en')
    {
        $result = array();
        $values = self::model()->findAllByAttributes(
            array(
                'language' => $lang
            )
        );

        if ($values) {
            foreach ($values as $value) {
                $result[] = array(
                    'value' => $value->value,
                    'group_id' => $value->group_id,
                );
            }
        }
        return $result;
    }

    public function beforeSave() {
        $this->value = str_replace(",", "", $this->value);
        return parent::beforeSave();
    }
}
