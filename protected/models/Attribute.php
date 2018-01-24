<?php

/**
 * This is the model class for table "attribute".
 *
 * The followings are the available columns in table 'attribute':
 * @property integer $id
 * @property string $type
 * @property string $alias
 * @property integer $required
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property AttributeName[] $attributeNames
 * @property ProductAttribute[] $productAttributes
 */
class Attribute extends CActiveRecord
{
    const ATTRIBUTE_STATUS_ACTIVE = 'active';
    const ATTRIBUTE_STATUS_INACTIVE = 'inactive';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, type', 'required', 'message' => '*required'),
			array('type, status', 'length', 'max'=>8),
			array('required', 'length', 'max'=>3),
			array('alias', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, alias, required, status', 'safe', 'on'=>'search'),
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
            'attributeNames' => array(self::HAS_MANY, 'AttributeName', 'attribute_id'),
            'productAttributes' => array(self::HAS_MANY, 'ProductAttribute', 'attribute_id'),
            'products' => array(self::MANY_MANY, 'Attribute', 'product_attribute(attribute_id, product_id)'),
            'categories' => array(self::MANY_MANY, 'Category', 'attribute_category(attribute_id, category_id)')
		);
	}

    public function behaviors(){
        return array( 'CAdvancedArBehavior' => array(
            'class' => 'application.extensions.CAdvancedArBehavior'));
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'type' => Yii::t('base', 'Type'),
			'alias' => Yii::t('base', 'Attribute name'),
			'required' => Yii::t('base', 'Is required'),
			'status' => Yii::t('base', 'Active'),
		);
	}

    public function scopes()
    {
        return array(
            'active'=>array(
                'condition' => 'status = "' . self::ATTRIBUTE_STATUS_ACTIVE . '"',
            ),
            'required'=>array(
                'condition' => 'required = "yes"',
            ),
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.type',$this->type,true);
		$criteria->compare('t.alias',$this->alias,true);
		$criteria->compare('t.required',$this->required);
		$criteria->compare('t.status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
             'sort' => array(
                'defaultOrder' => 't.id',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getTypes() {
        return array(
            'textarea' => Yii::t('base', 'textarea'),
            'text' => Yii::t('base', 'text'),
            'dropdown' => Yii::t('base', 'dropdown list'),
            'checkbox' => Yii::t('base', 'checkbox list'),
        );
    }

    public function getStatusName()
    {
        return Yii::t('base', $this->status);
    }

    public function getCategoriesAsString()
    {
        $res = '';
        if ($this->categories) {
            $res = implode(',', CHtml::listData($this->categories, 'id', 'alias'));
        }
        return $res;
    }

    public function getStatuses() {
        return array(self::ATTRIBUTE_STATUS_ACTIVE=> Yii::t('base', 'active'), self::ATTRIBUTE_STATUS_INACTIVE => Yii::t('base', 'inactive'));
    }

    public function getNameByLanguage($lang = 'en') {
        $names = $this->attributeNames;

        /// get default values for new language
        $result = AttributeName::model()->findByAttributes(array('attribute_id' => $this->id, 'language' => 'en'));
        if(!$result) {
            $defaults = array(
                'name' => '',
                'values' => '',
            );
            $result = new AttributeName;
            $result->attributes = $defaults;
        }
        $result->language = $lang;
        for($i = 0; $i < count($names); $i++) {
            if($names[$i]->language == $lang)
                $result = $names[$i];
        }
        return $result;
    }

     public function afterValidate()  {
        /// check for at least english name
        if (empty($_POST['name_en'])) {
            $this->addError('name_en', Yii::t('base', 'You should fill displayed attribute name for at least English language'));
        }
        return parent::afterValidate();
    }

      public function afterSave() {
        $this->saveNames($_POST);
        return parent::afterSave();
    }

    public function saveNames($data) {
        $languages = UtilsHelper::getLanguages();
        for($i = 0; $i < count($languages); $i++) {
            $name = AttributeName::model()->findByAttributes(
                array(
                    'attribute_id' => $this->id,
                    'language' => $languages[$i],
                )
            );
            $values = '';
            if (is_array($data['values_' . $languages[$i]])) {
                $data['values_' . $languages[$i]] = array_unique($data['values_' . $languages[$i]]);
            }
            if ($this->type=='checkbox' || $this->type=='dropdown') {
                if (is_array($data['values_' . $languages[$i]])) {
                    $values = implode(
                        ",",
                        $data['values_' . $languages[$i]]
                    );
                }
            } else {
                $values = $data['values_' . $languages[$i]];
            }

            if(!$name) {
                $name = new AttributeName;
                $name->attribute_id = $this->id;
                $name->language = $languages[$i];
            }
            $name->name = $data['name_' . $languages[$i]];
            if (empty($data['name_' . $languages[$i]])) {
                $name->name = $data['name_en'];
            }
            $name->values = $values;
            $name->save();
        }
    }

    public function getRequiredAttributes($categoryId)
    {
        $result = array();

        $required = Category::getAllAttributes($categoryId, array(
            'scopes' => array('active', 'required'),
            'with' => array(
                'attributeNames'=>array(
                    'joinType'=>'LEFT JOIN',
                    'condition'=>'attributeNames.language=\'' . Yii::app()->getLanguage() . '\''
                )
            )
        ));

        if ($required) {
            foreach ($required as $attr) {
                if (isset($result[$attr->id])) continue;

                if (isset($attr->attributeNames[0]->name)) {
                    $attrName = $attr->attributeNames[0]->name;
                } else {
                    $attrName = $attr->alias;
                }
                $result[$attr->id] = $attrName;
            }
        }

        return $result;
    }
}