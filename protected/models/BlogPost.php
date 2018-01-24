<?php

/**
 * This is the model class for table "blog_post".
 *
 * The followings are the available columns in table 'blog_post':
 * @property integer $id
 * @property string $title
 * @property string $short_description
 * @property string $content
 * @property string $image
 * @property string $image_title
 * @property string $seo_title
 * @property string $seo_description
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $publish_at
 * @property string $timezone
 * @property integer $allow_add_comments
 */
class BlogPost extends CActiveRecord
{
	const POST_STATUS_DRAFTED = 1;
	const POST_STATUS_PUBLISHED = 2;

	public $tags_field;
	public $categories_field;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, allow_add_comments', 'numerical', 'integerOnly'=>true),
			array('title, short_description', 'length', 'max'=>128),
			array('publish_at, seo_title, seo_description, content, image_title, timezone', 'safe'),
			array('image', 'length', 'max'=>1024),
			array('image', 'file', 'types'=>'jpeg, jpg, gif, png', 'allowEmpty'=>true),
			array('image','dimensionValidation'),
			array('status', 'in', 'range' => array(self::POST_STATUS_DRAFTED, self::POST_STATUS_PUBLISHED)),
			array('allow_add_comments', 'in', 'range' => array(0, 1)),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, image, image_title, status, create_time, update_time, publish_at, allow_add_comments, seo_title, seo_description, short_description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'tags' => array(self::MANY_MANY, 'BlogTag', 'blog_post_tag(post_id, tag_id)'),
			'categories' => array(self::MANY_MANY, 'BlogCategory', 'blog_post_category(post_id, category_id)'),
			'comments' => array(self::HAS_MANY, 'BlogComment', 'post_id'),
			'publishedComments' => array(self::HAS_MANY, 'BlogComment', 'post_id', 'scopes' => array('published', 'recently')),
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
			'title' => Yii::t('base', 'Post Title'),
			'short_description' => Yii::t('base', 'Short Description'),
			'content' => Yii::t('base', 'Text'),
			'image' => Yii::t('base', 'Image'),
			'image_title' => Yii::t('base', 'Image Title'),
			'status' => Yii::t('base', 'Status'),
			'seo_title' => Yii::t('base', 'Seo Title'),
			'seo_description' => Yii::t('base', 'Seo Description'),
			'create_time' => Yii::t('base', 'Added Date'),
			'update_time' => Yii::t('base', 'Updated Dated'),
			'publish_at' => Yii::t('base', 'Publish At'),
			'tags_field' => Yii::t('base', 'Tags'),
			'categories_field' => Yii::t('base', 'Categories'),
			'allow_add_comments' => Yii::t('base', 'Can add comments')
		);
	}

	public function scopes()
    {
        return array(
            'published'=>array(
                'condition' => 'status = ' . self::POST_STATUS_PUBLISHED,
            ),
            'recently'=>array(
                'order'=>'create_time DESC',
            ),
        );
    }

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave()
	{
		if(parent::beforeSave()) {
			if (empty($this->publish_at)) {
				$this->publish_at = null;
			}

			$temp = BlogPost::model()->findByPk($this->id);
			if (is_null($this->image) &&
				isset($_POST['BlogPost']['oldImage']) &&
				!empty($_POST['BlogPost']['oldImage'])) {
				$this->image = $temp->image;
			}
			if ($this->image != $temp->image) {
				ImageHelper::removeOldBlogImages($temp->image);
			}

			$dateNow = date('Y-m-d H:i:s');
			if($this->isNewRecord) {
				$this->create_time = $dateNow;
			}
			$this->update_time = $dateNow;
			return true;
		}
		else
			return false;
	}

    protected function beforeDelete()
    {
        if (!empty($this->image)) {
            ImageHelper::removeOldBlogImages($this->image);
        }

        return parent::beforeDelete();
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
		$criteria->compare('LOWER(t.title)',strtolower($this->title),true);
		$criteria->compare('LOWER(t.short_description)',strtolower($this->short_description),true);
		$criteria->compare('LOWER(t.content)',strtolower($this->content),true);
		$criteria->compare('t.image',$this->image,true);
		$criteria->compare('LOWER(t.image_title)',strtolower($this->image_title),true);
		$criteria->compare('LOWER(t.seo_title)',strtolower($this->seo_title),true);
		$criteria->compare('LOWER(t.seo_description)',strtolower($this->seo_description),true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('DATE(t.create_time)',$this->create_time,true);
		$criteria->compare('DATE(t.update_time)',$this->update_time,true);
		$criteria->compare('t.publish_at',$this->publish_at,true);
		$criteria->compare('t.allow_add_comments',$this->allow_add_comments);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
			    'defaultOrder' => 't.create_time DESC',
			),
		));
	}

	public function getAllowAddCommentsVariants()
	{
		return array(
			1 => Yii::t('base', 'Yes'),
			0 => Yii::t('base', 'No'),
		);
	}

	public function getAllowAddCommentsName()
	{
		$variants = $this->getAllowAddCommentsVariants();
	    $allowName = isset($variants[$this->allow_add_comments]) ?
	        $variants[$this->allow_add_comments] :
	        Yii::t('base', $this->allow_add_comments);
	    return $allowName;
	}

	public function getStatuses()
	{
	    return array(
	        self::POST_STATUS_DRAFTED => Yii::t('base', 'Drafted'),
	        self::POST_STATUS_PUBLISHED => Yii::t('base', 'Published'),
	    );
	}

	/**
	 * @property boolean $asArray
	 */
	public function getNormalizedTags($asArray = false)
	{
		$tags = CHtml::listData($this->tags, 'id', 'name');
		if ($asArray) {
			return $tags;
		}
		return implode(', ', $tags);
	}

	/**
	 * @property boolean $asArray
	 */
	public function getNormalizedCategories($asArray = false)
	{
		$categories = CHtml::listData($this->categories, 'id', 'name');
		if ($asArray) {
			return $categories;
		}
		return implode(', ', $categories);
	}

	public function getThumbnailImageTag($options = array())
	{
		$options = array_merge(
			array('title' => $this->image_title),
			$options
		);
		if (!empty($this->image)) {
			$getResultFromHelper = ImageHelper::get(
                $this->image,
                ShopConst::BLOG_IMAGE_THUMBNAIL_DIR,
                ShopConst::BLOG_IMAGE_MEDIUM_DIR
            );
            if (!empty($getResultFromHelper)) {
            	return CHtml::image(
            		$getResultFromHelper,
            		$this->image_title,
            		$options
            	);
            }
        }

        return '';
	}

	public function getMediumImageTag($options = array())
	{
		$options = array_merge(
			array('title' => $this->image_title),
			$options
		);
		if (!empty($this->image)) {
			$getResultFromHelper = ImageHelper::get(
                $this->image,
                ShopConst::BLOG_IMAGE_MEDIUM_DIR,
                ShopConst::BLOG_IMAGE_MAX_DIR
            );
            if (!empty($getResultFromHelper)) {
            	return CHtml::image(
            		$getResultFromHelper,
            		$this->image_title,
            		$options
            	);
            }
        }

        return '';
	}

	public function getMaxImageTag($options = array())
	{
		$options = array_merge(
			array('title' => $this->image_title),
			$options
		);
		if (!empty($this->image)) {
			$getResultFromHelper = ImageHelper::get(
                $this->image,
                ShopConst::BLOG_IMAGE_MAX_DIR,
                ShopConst::BLOG_IMAGE_MEDIUM_DIR
            );
            if (!empty($getResultFromHelper)) {
            	return CHtml::image(
            		$getResultFromHelper,
            		$this->image_title,
            		$options
            	);
            }
        }

        return '';
	}

	public function getUrl()
	{
		return Yii::app()->createAbsoluteUrl('members/blog/post', array('id' => $this->id));
	}

	public function getCommentCntAsText()
	{
		$cnt = count($this->publishedComments);
		if (!$cnt) {
			if (!$this->allow_add_comments) {
				return '';
			}
			$res = Yii::t('base', 'no comments');
		} else {
			$res = $cnt . ' ' . ($cnt > 1 ? Yii::t('base', 'comments') : Yii::t('base', 'comment'));
		}

		return $res;
	}

	public function getStatusName()
	{
	    $statuses = $this->getStatuses();
	    $statusName = isset($statuses[$this->status]) ?
	        $statuses[$this->status] :
	        Yii::t('base', $this->status);
	    return $statusName;
	}

	public static function getAllPosts()
	{
		$criteria = new CDbCriteria();
		$criteria->select = array('id', 'title');
	    $posts = self::model()->findAll($criteria);

	    $array = array();

	    foreach ($posts as $one) {
	        $array[$one->id] = $one->title;

	    }

	    return $array;
	}

	public function isPublished()
	{
		return $this->status == self::POST_STATUS_PUBLISHED;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlogPost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function dimensionValidation($attribute,$param) {
		if(is_object($this->image)){
			list($width, $height) = getimagesize($this->image->tempname);
			if($width < 100) {
				$this->addError('photo','Image size should be minimum 100px');
			}
		}
	}
}
