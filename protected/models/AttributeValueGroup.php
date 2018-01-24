<?php

/**
 * This is the model class for table "attribute_values_groups".
 *
 * The followings are the available columns in table 'attribute_values_groups':
 * @property integer $id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Attribute $attribute
 */
class AttributeValueGroup extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{attribute_values_groups}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('value', 'required', 'message' => '*required'),
            array('value', 'length', 'max'=>512),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, value', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'value' => Yii::t('base', 'Group name'),
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

    public static function getGroups()
    {
        $groups = array('' => Yii::t('base', 'Without group'));
        $arr = self::model()->findAll(array('index'=>'id'));
        if ($arr) {
            foreach ($arr as $row) {
                $groups[$row->id] = $row->value;
            }
        }
        return $groups;
    }
}
