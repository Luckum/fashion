<?php

/**
 * This is the model class for table "main_menu_images".
 *
 * The followings are the available columns in table 'main_menu_images':
 * @property integer $id
 * @property string $block_type
 * @property string $image1
 * @property string $link1_type
 * @property string $url1
 * @property string $image2
 * @property string $link2_type
 * @property string $url2
 */
class MainMenuImages extends CActiveRecord
{
	const ONE_IMAGE = '1 image';
	const TWO_IMAGES = '2 images';
	const NO_IMAGES = 'no images';

	const DIRECT_LINK = 'direct';
	const FILTER_LINK = 'filter';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'main_menu_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('block_type', 'required'),
			array('block_type', 'length', 'max'=>10),
			array('image1, url1, image2, url2', 'length', 'max'=>255),
			array('link1_type, link2_type', 'length', 'max'=>6),
			array('image1', 'file', 'types'=>'jpeg, jpg, gif, png', 'allowEmpty'=>true, 'on' => 'update'),
			array('image1','dimensionValidation'),
			array('image2', 'file', 'types'=>'jpeg, jpg, gif, png', 'allowEmpty'=>true),
			array('image2','dimensionValidation'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, block_type, image1, link1_type, url1, image2, link2_type, url2', 'safe', 'on'=>'search'),
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
			'block_type' => 'Block Type',
			'image1' => 'Image1',
			'link1_type' => 'Link1 Type',
			'url1' => 'Url1',
			'image2' => 'Image2',
			'link2_type' => 'Link2 Type',
			'url2' => 'Url2',
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
		$criteria->compare('block_type',$this->block_type,true);
		$criteria->compare('image1',$this->image1,true);
		$criteria->compare('link1_type',$this->link1_type,true);
		$criteria->compare('url1',$this->url1,true);
		$criteria->compare('image2',$this->image2,true);
		$criteria->compare('link2_type',$this->link2_type,true);
		$criteria->compare('url2',$this->url2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MainMenuImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getBlockType() 
	{
		return array(
			self::NO_IMAGES => Yii::t('base', 'No images'),
			self::ONE_IMAGE => Yii::t('base', '1 Image'),
			self::TWO_IMAGES => Yii::t('base', '2 Images'),
		);
	}

	public function getLinkType() 
	{
		return array(
			NULL => Yii::t('base', 'No link'),
			self::DIRECT_LINK => Yii::t('base', 'Direct Link'),
			self::FILTER_LINK => Yii::t('base', 'Filter Link'),
		);
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

	public function afterValidate()  {
		$temp = MainMenuImages::model()->findByPk($this->id);
		if ($this->image1 === null &&
			isset($_POST['MainMenuImages']['oldImage1']) &&
			!empty($_POST['MainMenuImages']['oldImage1'])) {
			$this->image1 = $temp->image1;
		} 
		if ($this->image2 === null &&
			isset($_POST['MainMenuImages']['oldImage2']) &&
			!empty($_POST['MainMenuImages']['oldImage2'])) {
			$this->image2 = $temp->image2;
		} 
		if ($this->image1 != $temp->image1) {
			ImageHelper::removeOldHomeblockImages($temp->image1);
		}
		if ($this->image2 != $temp->image2) {
			ImageHelper::removeOldHomeblockImages($temp->image2);
		}

		return parent::afterValidate();
    }

    public function dimensionValidation($attribute,$param) {
		if(is_object($this->image1)){
			list($width, $height) = getimagesize($this->image1->tempname);
			if($width < 100) {
				$this->addError('photo','Image size should be minimum 100px');
			}
		}	
		if(is_object($this->image2)){
			list($width, $height) = getimagesize($this->image2->tempname);
			if($width < 100) {
				$this->addError('photo','Image size should be minimum 100px');
			}
		}	
	}

	public function getRelativeUrl($url) {
	   $purl = parse_url($url);

	   //if($purl['host']=='23-15.com' || $purl['host']=='23-15.de')
	    	$url = $purl['path'];
	 
	    return $url;
	}
}
