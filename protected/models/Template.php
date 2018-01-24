<?php

/**
 * This is the model class for table "email_template".
 *
 * The followings are the available columns in table 'email_template':
 * @property integer $id
 * @property string $alias
 * @property string $content
 * @property string $subject
 * @property string $language
 * @property string $priority
 */
class Template extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, content, subject, language', 'required', 'message' => '*required'),
			array('alias', 'length', 'max'=>255),
			array('subject', 'length', 'max'=>50),
			array('language', 'length', 'max'=>2),
			array('alias', 'checkAlias', 'on' => 'create'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alias, content, subject, language, priority', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'alias' => 'Alias',
			'content' => 'Content',
			'subject' => 'Subject',
			'language' => 'Language',
			'priority' => 'Priority'
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('language',$this->language,true);
        $criteria->compare('priority',$this->language,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Template the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getContentByLanguage($lang = 'en') {
		$content = $this->content;
		
		$result = self::model()->findByAttributes(array('alias' => $this->alias, 'language' => $lang));
		if(!$result) {
			$result = new Template;
			$result->language = $lang;
		}
		
		return $result;
	}

	public function beforeValidate()  {
        /// check for at least english name
        if($_POST['content_en'] == '') $this->addError('content_en', Yii::t('base', 'You should fill content for at least English language'));
        if($_POST['subject_en'] == '') $this->addError('subject_en', Yii::t('base', 'You should fill subject for at least English language'));
        $this->content = $_POST['content_en'];
        $this->subject = $_POST['subject_en'];
        $this->language = 'en';

        return parent::beforeValidate();
    }

    public function afterSave() {
        $this->saveContent($_POST);
        return parent::afterSave();
    }
	
	public function saveContent($data) {
		$languages = UtilsHelper::getLanguages();
		$values = array();
		for($i = 1; $i < count($languages); $i++) {
			if ($languages[$i] == 'en') {
				continue;
			}
			$content = Template::model()->findByAttributes(array('alias' => $this->alias, 'language' => $languages[$i]));
			if(!$content) {
				$sql = "INSERT INTO `".Template::model()->tableSchema->name."` 
						(`id`, `alias`, `content`, `subject`, `language`) 
						VALUES (NULL, '".$this->alias."', '".$data['content_' . $languages[$i]]."', '".$data['subject_' . $languages[$i]]."', '".$languages[$i]."');";
		        $connection=Yii::app()->db;                     
		        $command=$connection->createCommand($sql)->execute();;
			} else {
				$sql = "UPDATE `".Template::model()->tableSchema->name."` 
						SET `alias`='".$this->alias."', 
							`content`='".$data['content_' . $languages[$i]]."', 
							`subject`='".$data['subject_' . $languages[$i]]."', 
							`language`='".$languages[$i]."'
						WHERE `id`=".$content->id;
		        $connection=Yii::app()->db;                     
		        $command=$connection->createCommand($sql)->execute();;
			}
		}
	}

	public function checkAlias($attribute, $params) {
		$alias = Template::model()->count('alias = :alias',[':alias' => $this->alias]);
		if($alias > 0) {
			$this->addError('alias', Yii::t('base', 'You have this alias on templates'));
			return false;
		} else {
			return true;
		}
	}
}
