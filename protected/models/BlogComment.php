<?php

/**
 * This is the model class for table "blog_comment".
 *
 * The followings are the available columns in table 'blog_comment':
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 * @property integer $post_id
 *
 * The followings are the available model relations:
 * @property User $author
 * @property BlogPost $post
 */
class BlogComment extends CActiveRecord
{
	const COMMENT_STATUS_PUBLISHED = 1;
	const COMMENT_STATUS_UNPUBLISHED = 2;

	public $author_search;
	public $title_search;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, status, post_id, author_id', 'required'),
			array('status, author_id, post_id', 'numerical', 'integerOnly'=>true),
			array('status', 'in', 'range' => array(self::COMMENT_STATUS_PUBLISHED, self::COMMENT_STATUS_UNPUBLISHED)),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, content, status, create_time, update_time, author_id, post_id, author_search, title_search', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'post' => array(self::BELONGS_TO, 'BlogPost', 'post_id'),
		);
	}

    public function published($val = true)
	{
	    $criteria = $this->getDbCriteria();
	    $alias = $this->getTableAlias();

	    $criteria->mergeWith(array(
	        'condition' => $alias . '.status=' . self::COMMENT_STATUS_PUBLISHED,
	    ));

	    return $this;
	}

	public function recently()
	{
	    $criteria = $this->getDbCriteria();
	    $alias = $this->getTableAlias();

	    $criteria->mergeWith(array(
	        'order' => $alias . '.create_time DESC',
	    ));

	    return $this;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'content' => Yii::t('base', 'Content'),
			'status' => Yii::t('base', 'Status'),
			'create_time' => Yii::t('base', 'Added Date'),
			'update_time' => Yii::t('base', 'Updated Dated'),
			'author_id' => Yii::t('base', 'Author'),
			'post_id' => Yii::t('base', 'Post'),
			'author_search' => Yii::t('base', 'Author'),
			'title_search' => Yii::t('base', 'Post Title'),
		);
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave()
	{
		if(parent::beforeSave()) {
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
		$criteria->with = array('author', 'post');

		$criteria->compare('t.id',$this->id);
		$criteria->compare('LOWER(t.content)',strtolower($this->content),true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.create_time',$this->create_time);
		$criteria->compare('t.update_time',$this->update_time);
		$criteria->compare('t.author_id',$this->author_id);
		$criteria->compare('t.post_id',$this->title_search);
		$criteria->compare('LOWER(author.username)',strtolower($this->author_search),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
			    'defaultOrder' => 't.create_time DESC',
			    'attributes'=>array(
			        'author_search'=>array(
			            'asc'=>'author.username',
			            'desc'=>'author.username DESC',
			        ),
			        'title_search'=>array(
			            'asc'=>'post.title',
			            'desc'=>'post.title DESC',
			        ),
			        '*',
			    ),
			),
		));
	}

	public function getStatuses()
	{
	    return array(
	        self::COMMENT_STATUS_PUBLISHED => Yii::t('base', 'Published'),
	        self::COMMENT_STATUS_UNPUBLISHED => Yii::t('base', 'Unpublished'),
	    );
	}

	public function getStatusName()
	{
	    $statuses = $this->getStatuses();
	    $statusName = isset($statuses[$this->status]) ?
	        $statuses[$this->status] :
	        Yii::t('base', $this->status);
	    return $statusName;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlogComment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
