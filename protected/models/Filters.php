<?php

/**
 * This is the model class for table "filters".
 *
 * The followings are the available columns in table 'filters':
 * @property integer $id
 * @property integer $user_id
 * @property string $category
 * @property string $brand
 * @property string $size_type
 * @property string $country
 * @property string $condition
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Filters extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'filters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required', 'message' => '*required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('category, brand, size_type, country, condition, seller_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, category, brand, size_type, country, condition, seller_type', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'category' => 'Category',
			'brand' => 'Brand',
			'size_type' => 'Size Type',
			'country' => 'Country',
			'condition' => 'Condition',
            'seller_type' => 'Seller type',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('size_type',$this->size_type,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('condition',$this->condition,true);
        $criteria->compare('seller_type',$this->seller_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Filters the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFilter($where) {
        if ($filters=Filters::model()->findByAttributes(array('user_id'=>Yii::app()->member->id))) {
    		foreach ($filters->attributes as $filter => $values) {
    			switch ($filter) {
    				case 'category':
                        $filterWhere = array('or');
    					foreach (explode(',', $values) as $id) {
    						if(!$id) {
    							continue;
    						}
    						array_push($filterWhere, 't.category_id = '.$id);
    					}
                        array_push($where, $filterWhere);
    					break;

    				case 'brand':
                        $filterWhere = array('or');
    					foreach (explode(',', $values) as $id) {
    						if(!$id) {
    							continue;
    						}
    						array_push($filterWhere, 't.brand_id = '.$id);
    					}
                        array_push($where, $filterWhere);
    					break;

    				case 'size_type':
                        $filterWhere = array('or');
    					foreach (explode(',', $values) as $id) {
    						if(!$id) {
    							continue;
    						}
    						array_push($filterWhere, 't.size_type = "'.$id.'"');
    					}
                        array_push($where, $filterWhere);
    					break;

    				case 'country':
                        $filterWhere = array('or');
    					foreach (explode(',', $values) as $id) {
    						if(!$id) {
    							continue;
    						}
    						array_push($filterWhere, 't.country_id = '.$id);
    					}
                        array_push($where, $filterWhere);
    					break;

    				case 'condition':
                        $filterWhere = array('or');
    					foreach (explode(',', $values) as $id) {
    						if(!$id) {
    							continue;
    						}
    						array_push($filterWhere, 't.condition = '.$id);
    					}
                        array_push($where, $filterWhere);
    					break;
                    case 'seller_type':
                        $filterWhere = array('or');
                        foreach (explode(',', $values) as $seller_code) {
                            if ($seller_code != '') {
                                $sellerTypes = SellerProfile::getConditions();
                                if (isset($sellerTypes[$seller_code])) {
                                    array_push($filterWhere, 't.seller_type = "'.$sellerTypes[$seller_code].'"');
                                }
                            }
                        }
                        array_push($where, $filterWhere);
                        break;
    				
    				default:
    					break;
    			}
    		}
    	} else {
    		$filters=new Filters;
    		$filters->user_id = Yii::app()->member->id;
    		$filters->save();
    	}        

    	return array($filters, $where);
	}

	public function setFilter($filters, $where, $isSave = true) {
        $filter_model=Filters::model()->findByAttributes(array('user_id'=>Yii::app()->member->id));
		if (!$filter_model) {
			$filter_model = new Filters;
			$filter_model->user_id = Yii::app()->member->id;
		}
		
		foreach ($filters as $filter => $values) {
			switch ($filter) {
				case 'category':
                    $filterWhere = array('or');
					if (count($values) == 1) {
						$filter_model->category = '';
					} else {
						foreach ($values as $id => $name) {
							if ($id == 0) {
								continue;
							}
    						array_push($filterWhere, 't.category_id = '.$id);
    					}
    					$filter_model->category = implode(',', array_keys($values));
					}
                    array_push($where, $filterWhere);
					break;

				case 'brand':
                    $filterWhere = array('or');
					if (count($values) == 1) {
						$filter_model->brand = '';
					} else {
    					foreach ($values as $id => $name) {
    						if ($id == 0) {
								continue;
							}
    						array_push($filterWhere, 't.brand_id = '.$id);
    						$filter_model->brand = implode(',', array_keys($values));
    					}
    				}
                    array_push($where, $filterWhere);
					break;

				case 'size_type':
                    $filterWhere = array('or');
					if (count($values) == 1) {
						$filter_model->size_type = '';
					} else {
    					foreach ($values as $id => $name) {
    						if (empty($id)) {
								continue;
							}
    						array_push($filterWhere, 't.size_type = "'.$id.'"');
    						$filter_model->size_type = implode(',', array_keys($values));
    					}
    				}
                    array_push($where, $filterWhere);
					break;

				case 'country':
                    $filterWhere = array('or');
					if (count($values) == 1) {
						$filter_model->country = '';
					} else {
    					foreach ($values as $id => $name) {
    						if ($id == 0) {
								continue;
							}
    						array_push($filterWhere, 't.country_id = '.$id);
    					}
    					$filter_model->country = implode(',', array_keys($values));
    				}
                    array_push($where, $filterWhere);
					break;

				case 'condition':
                    $filterWhere = array('or');
					if (count($values) == 1) {
						$filter_model->condition = '';
					} else {
    					foreach ($values as $id => $name) {
    						if ($id == 0) {
								continue;
							}
    						array_push($filterWhere, 't.condition = '.$id);
    					}
    					$filter_model->condition = implode(',', array_keys($values));
    				}
                    array_push($where, $filterWhere);
					break;

                case 'seller_type':
                    $filterWhere = array('or');
                    $storedValues = array();
                    foreach ($values as $id => $name) {
                        if (!($id == "0" && $name == "0")) {
                            array_push($filterWhere, 't.seller_type = "'.$name.'"');
                            array_push($storedValues, $id);
                        }
                    }
                    $filter_model->seller_type = implode(',', $storedValues);
                    array_push($where, $filterWhere);
                    break;
				
				default:
					break;
			}
		}
		
        if ($isSave) {
            $filter_model->save();
        }
        if (isset($_POST['clear_all'])) {
            Filters::model()->deleteAllByAttributes(array(
                'user_id'=>Yii::app()->member->id
            ));
        }

        array_push($where, $filterWhere);

		return array($filter_model, $where);
	}
}