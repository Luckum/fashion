<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property string $slug
 * @property string $page_title
 * @property integer $menu_order
 * @property integer $footer_order
 * @property string $status
 *
 * The followings are the available model relations:
 * @property PageContent[] $pageContents
 */
class Page extends CActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	const POSITION_FOOTER = 0;
	const POSITION_MENU = 1;
	const POSITION_FOOTER_AND_MENU = 2;
	public $title;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slug, page_title', 'required', 'message' => '*required'),
			array('footer_order, menu_order, position', 'numerical', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>255),
			array('page_title', 'length', 'max'=>255),
			array('slug', 'slugValidate'),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug, page_title, menu_order, footer_order, position, status', 'safe', 'on'=>'search'),
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
			'pageContents' => array(self::HAS_MANY, 'PageContent', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'slug' => Yii::t('base', 'Page slug'),
			'page_title' => Yii::t('base', 'Page title'),
			'title' => Yii::t('base', 'SEO Title'),
			'menu_order' => Yii::t('base', 'Menu Location'),
			'footer_order' => Yii::t('base', 'Footer Location'),
			'status' => Yii::t('base', 'Status'),
			'position' => Yii::t('base', 'Position'),
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('footer_order',$this->footer_order);
		$criteria->compare('menu_order',$this->menu_order);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Page the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatusName() 
	{
		$statuses = $this->getStatuses();
		return $statuses[$this->status];
	}

	public function getPositionName()
	{
		$positions = $this->getPositions();
		return $positions[$this->position];
	}

	public function getMaxFooterOrder()
	{
		$sql = "select * from " . $this->tableName() . " where position !=".self::POSITION_MENU." order by footer_order desc";
		$maxRecord = $this->findBySql($sql);
		if(!$maxRecord) return 0;
		else return $maxRecord->footer_order;
	}

	public function getMaxMenuOrder()
	{
		$sql = "select * from " . $this->tableName() . " where position !=".self::POSITION_FOOTER." order by menu_order desc";
		$maxRecord = $this->findBySql($sql);
		if(!$maxRecord) return 0;
		else return $maxRecord->menu_order;
	}

	public function getFooterOrders() {
		$footerOrders = array();
		$max = self::model()->getMaxFooterOrder();

		if(!$max) 
			$max = 1;
		else
			$max++;

		for($i = 0; $i <= ($max); $i++) {
			$footerOrders[$i] = $i;
		}
		return $footerOrders;
	}

	public function getMenuOrders() {
		$menuOrders = array();
		$max = self::model()->getMaxMenuOrder();

		if(!$max)
			$max = 1;
		else
			$max++;

		for($i = 0; $i <= ($max); $i++) {
			$menuOrders[$i] = $i;
		}
		return $menuOrders;
	}

	public function getStatuses() 
	{
		return array(
			'active' => Yii::t('base', 'Active'),
			'inactive' => Yii::t('base', 'Inactive'),
		);
	}

	public function getPositions()
	{
		return array(
			self::POSITION_FOOTER => Yii::t('base', 'Footer'),
			self::POSITION_MENU => Yii::t('base', 'Menu'),
			self::POSITION_FOOTER_AND_MENU => Yii::t('base', 'Footer & Menu'),
		);
	}

	public function getContentByLanguage($lang = 'en') {
		$content = $this->pageContents;
		
		/// get default values for new language
		$result = PageContent::model()->findByAttributes(array('page_id' => $this->id, 'language' => 'en'));
		if(!$result) {
			$defaults = array(
				'content' => '',
				'title' => '',
				'seo_description' => '',
				'seo_keywords' => '', 
			);
			$result = new PageContent;
			$result->attributes = $defaults;
		}
		$result->language = $lang;
		for($i = 0; $i < count($content); $i++) {
			if($content[$i]->language == $lang)
				$result = $content[$i];
		}
		return $result;
	}

	public function getTitleByLanguage($id,$lang = 'en') {
		$result = PageContent::model()->findByAttributes(array('page_id' => $id, 'language' => 'en'));

		return $result->title;
	}

	public function reOrder($order, $direction = 'inc') {
		if($direction == 'inc') $sign = '+';
		else $sign = '-';
		$command = Yii::app()->db->createCommand("update " . $this->tableName() . " set footer_order = footer_order $sign 1 where footer_order >= " . $order);
		$command->execute();
	}

	public function slugValidate($attribute,$params)
	{
	    if(preg_match('/[a-z0-9] | [^\s]/', $this->$attribute))
	    	$this->addError($attribute, 'Slug must contain only letter and numbers, without space!');
	}

	public function afterValidate()  {
        /// check for at least english name
        if($_POST['content_en'] == '') $this->addError('content_en', Yii::t('base', 'You should fill post content for at least English language'));
        return parent::afterValidate();
    }

	/// recalculate categories order on save for new categories
	public function beforeSave() {
		if($this->isNewRecord && $this->footer_order > 0) {
			$this->reOrder($this->footer_order);	
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
				'seo_description' => $data['seo_description_' . $languages[$i]],
				'seo_keywords' => $data['seo_keywords_' . $languages[$i]],
			);
			$content = PageContent::model()->findByAttributes(array('page_id' => $this->id, 'language' => $languages[$i]));
			if(!$content) {
				$content = new PageContent;
				$content->page_id = $this->id;
				$content->language = $languages[$i];
				$content->content = $data['content_' . $languages[$i]];
			}
			$content->attributes = $values[$languages[$i]];
			$content->save();
		}
	}

	public static function getPages() {
		$criteria = new CDbCriteria;
        $criteria->condition = 'footer_order != 0 AND status = "active"';
        $criteria->order = 'footer_order ASC';
        $pages = self::model()->findAll($criteria);

        return $pages;
	}

	public static function getPage($slug) {
		$criteria = new CDbCriteria;
        $criteria->condition = 'slug = "'.$slug.'"';
        $page = self::model()->find($criteria);

        return $page;
	}

	public function getStaticPageData($name, $lang)
    {
        $result = array();
        // Получаем данные о странице.
        $with = array('pageContents' => array(
            'condition' => 'language = :lang',
            'params' => array('lang' => $lang)
        ));
        $data = self::model() -> with($with) -> findAllByAttributes(array(
            'slug'   => $name,
            'status' => 'active'
        ));
        if (count($data)) {
            $result = $data[0]['pageContents'][0];
        }
        return $result;
    }
}
