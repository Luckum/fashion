<?php

/**
 * This is the model class for table "homepage_block".
 *
 * The followings are the available columns in table 'homepage_block':
 * @property integer $id
 * @property string $image
 * @property string $link_type
 * @property string $url
 * @property integer $order
 * @property integer $visible
 *
 * The followings are the available model relations:
 * @property HomepageBlockContent[] $homepageBlockContents
 */
class HomepageBlock extends CActiveRecord
{
	const DIRECT_LINK = 'direct';
	const FILTER_LINK = 'filter';
	const PATH_TO_PROD = '/site/products/';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'homepage_block';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url', 'required', 'message' => '*required'),			
			array('image, url', 'length', 'max'=>255),
			array('link_type, visible', 'length', 'max'=>6),
			array('image', 'file', 'types'=>'jpeg, jpg, gif, png', 'allowEmpty'=>true, 'on' => 'update'),
			array('image','dimensionValidation'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, block_type, link_type, url, visible', 'safe', 'on'=>'search'),
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
			'homepageBlockContents' => array(self::HAS_MANY, 'HomepageBlockContent', 'block_id', 'condition' => 'language=:lang', 'params' => array(':lang' => Yii :: app() -> language)),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'Image',
			'link_type' => 'Link Type',
			'url' => 'Url',			
			'block_type' => 'Block Type',
			'visible' => 'Visible?'
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
		$criteria->with = 'homepageBlockContents';

		$criteria->compare('id',$this->id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('link_type',$this->link_type,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('visible', $this->visible, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HomepageBlock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getLinkType() 
	{
		return array(
			self::DIRECT_LINK => Yii::t('base', 'Direct Link'),
			self::FILTER_LINK => Yii::t('base', 'Filter Link'),
		);
	}

    /**
     * Возвращает данные для блоков на главной странице.
     */
	public static function getHomePageBlocks()
	{
        // Получаем все блоки для главной страницы из базы.
        return HomepageBlock :: model()
                -> with('homepageBlockContents')
                -> findAll('visible = 1');
	}

	public function getContentByLanguage($lang = 'en') {
		$content = $this->homepageBlockContents;
		
		/// get default values for new language
		$result = HomepageBlockContent::model()->findByAttributes(array('block_id' => $this->id, 'language' => 'en'));
		if(!$result) {
			$defaults = array(
				'title' => '',
				'content' => '',
			);
			$result = new HomepageBlockContent;
			$result->attributes = $defaults;
		}
		$result->language = $lang;
		for($i = 0; $i < count($content); $i++) {
			if($content[$i]->language == $lang)
				$result = $content[$i];
		}
		return $result;
	}

	public function existImg($img) {
    	$criteria = new CDbCriteria;
		$criteria->select = '*';
		$criteria->condition = 'image = :image';
		$criteria->params = array(':image'=>$img);
		$block = HomepageBlock::model()->findAll($criteria);
		return count($block);
    }

    public function afterValidate()  {
        if($_POST['title_en'] == '') $this->addError('title_en', Yii::t('base', 'You should fill title for at least English language'));
        //if($_POST['content_en'] == '') $this->addError('content_en', Yii::t('base', 'You should fill content for at least English language'));

		// don't rewrite image with null
		//
		$temp = HomepageBlock::model()->findByPk($this->id);
		if ($this->image === null &&
			isset($_POST['HomepageBlock']['oldImage']) &&
			!empty($_POST['HomepageBlock']['oldImage'])) {
			$this->image = $temp->image;
		} 
		if ($this->image != $temp->image) {
			ImageHelper::removeOldHomeblockImages($temp->image);
		}

		return parent::afterValidate();
    }

    public function reOrder($order, $direction = 'inc') {
		if($direction == 'inc') $sign = '+';
		else $sign = '-';
		$command = Yii::app()->db->createCommand("update " . $this->tableName() . " set `order` = `order` $sign 1 where `order` >= " . $order);
		$command->execute();
	}
	
	/// recalculate categories order on save for new categories
	public function beforeSave() {
		if($this->isNewRecord && $this->order > 0) {
			$this->reOrder($this->order);	
		}
		return parent::beforeSave();
	}

    public function afterSave() {
        $this->saveContent($_POST);
        return parent::afterSave();
    }
	
	public function saveContent($data) {
		$languages = UtilsHelper::getLanguages();
		$values = array();
		for($i = 0; $i < count($languages); $i++) {
			$values[$languages[$i]] = array(
				'content' => $data['content_' . $languages[$i]],
				'title' => $data['title_' . $languages[$i]],
			);
			$content = HomepageBlockContent::model()->findByAttributes(array('block_id' => $this->id, 'language' => $languages[$i]));
			if(!$content) {
				$content = new HomepageBlockContent;
				$content->block_id = $this->id;
				$content->language = $languages[$i];
			}
			$content->attributes = $values[$languages[$i]];
			$content->save();
		}
	}

	public function getFilters() {
		$filters = array(
			'Brand'     => FilterHelper :: BrandFilterParameterName,
			'Color'     => FilterHelper :: ColorFilterParameterName,
			'Size'      => FilterHelper :: SizeFilterParameterName,
			'Category'  => FilterHelper :: CategoryFilterParameterName,
			'Seller'    => FilterHelper :: SellerFilterParameterName,
			'Condition' => FilterHelper :: ConditionFilterParameterName
		);
		return $filters;
	}

	public function getOrders() {
		$orders = array();
		$max = self::model()->getMaxOrder();

		if(!$max) 
			$max = 1;
		else
			$max++;

		for($i = 0; $i <= ($max); $i++) {
			$orders[$i] = $i;
		}
		return $orders;
	}

	public function getMaxOrder() 
	{
		$sql = "select * from " . $this->tableName() . " order by `order` desc";
		$maxRecord = $this->findBySql($sql);
		if(!$maxRecord) return 0;
		else return $maxRecord->order;
	}

	public function dimensionValidation($attribute,$param) {
		if(is_object($this->image)){
			list($width, $height) = getimagesize($this->image->tempname);
			if($width < 100) {
				$this->addError('photo','Image size should be minimum 100px');
			}
		}	
	}

	public static function getBlocks() {
		$criteria = new CDbCriteria;   
        $blocks = self::model()->findAll($criteria);

        return $blocks;
	}

	public function getRelativeUrl($url) {
	   $purl = parse_url($url);

	   //if($purl['host']=='23-15.com' || $purl['host']=='23-15.de')
	    	$url = $purl['path'];
	 
	    return $url;
	}
}
