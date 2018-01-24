<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $seller_id
 * @property string $comment
 * @property string $response
 * @property string $comment_status
 * @property string $response_status
 * @property string $added_date
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property User $user
 * @property Product $seller
 */
class Comments extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, user_id, seller_id, added_date', 'required', 'message' => '*required'),
            array('comment', 'required', 'on' => 'comment', 'message' => '*required'),
            array('response', 'required', 'on' => 'reply', 'message' => '*required'),
            array('product_id, user_id, seller_id', 'numerical', 'integerOnly' => true),
            array('comment, response', 'length', 'max' => 255),
            array('comment_status, response_status', 'length', 'max' => 9),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, user_id, seller_id, comment, response, comment_status, response_status, added_date', 'safe', 'on' => 'search'),
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
            'seller' => array(self::BELONGS_TO, 'Product', 'seller_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'user_id' => 'User',
            'seller_id' => 'Seller',
            'comment' => 'Comment',
            'response' => 'Response',
            'comment_status' => 'Comment Status',
            'response_status' => 'Response Status',
            'added_date' => 'Added Date',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('seller_id', $this->seller_id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('response', $this->response, true);
        $criteria->compare('comment_status', $this->comment_status, true);
        $criteria->compare('response_status', $this->response_status, true);
        $criteria->compare('added_date', $this->added_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getCountComments()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("comment_status = 'banned' OR response_status = 'banned'");

        $count = self::model()->count($criteria);

        return $count;
    }

    public static function getComments($productIds)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("comment_status = 'published'");
        $criteria->addInCondition('product_id', $productIds);
        $criteria->addCondition("seller_id = " . Yii::app()->member->id);
        $criteria->order = 't.id DESC';
        $criteria->together = true;
        $criteria->with = array('product');

        $result = self::model()->findAll($criteria);

        return $result;
    }

    public static function splitCommentsArray($comments)
    {
        $commentsForVisibleBlock = array();
        $commentsForHiddenBlock = array();
        $commentsForVisibleBlock = array_filter(
            $comments,
            function ($el) {
                return $el->read != 1;
            }
        );
        if (!empty($commentsForVisibleBlock)) {
            $commentsForHiddenBlock = array_filter(
                $comments,
                function ($el) {
                    return $el->read == 1;
                }
            );
        } else {
            $commentsForVisibleBlock = array_slice($comments, 0, 5);
            $commentsForHiddenBlock = array_slice($comments, 5);
        }

        return array($commentsForVisibleBlock, $commentsForHiddenBlock);
    }

    public static function getUnreadComments(){
        $criteria = new CDbCriteria();
        $criteria->addCondition("(comment_status = 'published'
                                  AND response_status = 'published'
                                  AND `read` IS NULL
                                  AND seller_id = " . Yii::app()->member->id . ")");

        $result = self::model()->findAll($criteria);

        return $result;
    }

    public function addComment($reply = false)
    {
        $status = $this->verifiedComment($_POST['comment']);
        if ($status == "delete") {
            return false;
        }
        
        if ($reply === false) {
            $product = Product::model()->findByPk($_POST['id']);
            if ($product && !$product->canUserAddCommentsAndMakeOffers()) {
                return false;
            }
            $this->setScenario('comment');
            $this->product_id = $product->id;
            $this->user_id = Yii::app()->member->id;
            $this->seller_id = $product->user_id;
            $this->comment = CHtml::encode($_POST['comment']);
            $this->comment_status = $status;
            $this->added_date = date('Y-m-d H:i:s');
            if ($this->save()) {
                if($status != 'banned') {
                    $user = User:: model()->findByPk(Yii::app()->member->id);
                    $product = Product::model()->findByPk($product->id);
                    $seller = User::model()->findByPk($product->user_id);
                    $template = Template::model()->find("alias = 'comment_received' AND language = :lang", array(':lang' => $user->language));
                    if(count($template)) {
                        $parameters = EmailHelper::setValues($template->content, array(
                                $product,
                                $seller,
                                $this,
                                array(
                                    'Option' => array(
                                        'link' =>
                                            Yii:: app()->request->hostInfo .
                                            Yii:: app()->createUrl(
                                                Yii:: app()->getLanguage() . '/my-account/inbox'),
                                    )
                                )
                            )
                        );
                        $mail = new Mail();
                        $mail->send(
                            $seller->email,
                            $template->subject,
                            Yii::t('base', $template->content, $parameters),
                            $template->priority
                        );
                    }
                } else {
                    return false;
                }
                return $this;
            }
        } else {
            $comment = self::model()->findByPk($_POST['id']);
            $comment->setScenario('reply');
            $comment->response = CHtml::encode($_POST['comment']);
            $comment->response_status = $status;
            if ($comment->save()) {
                return $comment;
            }
        }
        return false;
    }

    public function verifiedComment($comment)
    {
        $comment_word = explode(" ", $comment);
        $bannedWords = array_filter(Yii::app()->params['bannedwords']);

        if (!empty($bannedWords)) {
            $isContainBannedWords = preg_match_all(
                  "/\b(" . implode($bannedWords,"|") . ")\b/i", 
                  $comment, 
                  $matches
            );
            if ($isContainBannedWords) {
                return 'delete';
            }
        }       

        //phone
        if (preg_match("/\d\d\d\s*-\s*\d\d\s*-\s*\d\d/", $comment) ||
            preg_match("/\d\d\d\s*-\s*\d\d\d\d/", $comment) ||
            preg_match("/\d{7}/", $comment)) {
            return 'delete';
        }
        //email
        if (preg_match("/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/", $comment) ||
            preg_match("/[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]/", $comment)) {
            return 'delete';
        }  

        if (!empty($bannedWords)) {
            foreach ($comment_word as $word) {
                if (in_array($word, $bannedWords)) {
                    $this->comment_status = 'banned';
                    return 'delete';

                }           
            }
        }

        return 'published';
    }
}
