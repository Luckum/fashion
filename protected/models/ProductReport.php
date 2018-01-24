<?php

/**
 * This is the model class for table "product_report".
 *
 * The followings are the available columns in table 'product_report':
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property string $comment
 */
class ProductReport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, user_id, comment, added_date', 'required', 'message' => '*required'),
			array('product_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, user_id, comment, added_date', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'product_id' => Yii::t('base', 'Product'),
			'user_id' => Yii::t('base', 'From'),
			'comment' => Yii::t('base', 'Comment'),
			'added_date' => Yii::t('base', 'Report Date'),
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('added_date',$this->added_date,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Создает новую жалобу.
     */
	public function addReport()
	{
        // станавливаем значение параметров.
        $this -> product_id = $_POST['pid'];
        $this -> comment    = $_POST['cmp'];
        $this -> user_id    = Yii :: app() -> member -> id;
        $this -> added_date = new CDbExpression('NOW()');

        if ($this -> save()) {
            // Отправка уведомляющего e-mail.
            $template = Template :: model() -> find("alias = 'new_complaint' AND language = :lang", array(':lang' => 'en'));
            if (count($template)) {
                $mail = new Mail();
                $mail -> send(
                    Yii :: app() -> params['misc']['adminEmail'],
                    $template -> subject,
                    Yii :: t('base', $template -> content . "<p>&nbsp;</p> User profile:      " . $_POST['prf']
                                                          . "<p>&nbsp;</p> Product Page: " . $_POST['pge']
                                                          . "<p>&nbsp;</p> Comment:   " . $_POST['cmp'])
                );
            }
            return true;
        } else {
            // Не удалось сохранить жалобу в базу.
            return false;
        }
	}
}
