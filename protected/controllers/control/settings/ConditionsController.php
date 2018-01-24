<?php

class ConditionsController extends AdminController
{
    public function actionIndex()
    {
        $data = Yii::app()->params->conditions;
        $oldTypes = $data['types'];

        if (isset($_POST['save'])) {
            $types = explode(',', $_POST['types']);
            if (count($types)) {
                UtilsHelper :: writeConditionSettings('conditions', 'types', $types);
                $data['types'] = $types;
                $oldIndex = 1;
                $dataForUpdate = array();
                foreach ($oldTypes as $oldCondValue) {
                    if (($newIndex = array_search($oldCondValue, $types)) !== FALSE) {
                        $newIndex++;
                        if ($oldIndex != $newIndex) {
                            $criteria = new CDbCriteria;
                            $criteria->condition = "`condition` = :condition";
                            $criteria->params = array(':condition' => $oldIndex);
                            $criteria->select = array('id');
                            $products = Product::model()->findAll($criteria);
                            $ids = array();
                            foreach ($products as $product) {
                                $ids[] = $product->id;
                            }
                            if (!empty($ids)) {
                                $dataForUpdate[$newIndex] = $ids;
                            }
                        }
                    } else {
                        Product::model()->updateAll(array(
                            "condition" => ''
                        ), "`condition` = :condition", array(':condition' => $oldIndex));
                    }
                    $oldIndex++;
                }

                foreach ($dataForUpdate as $newIndex => $ids) {
                    $updateCriteria = new CDbCriteria;
                    $updateCriteria->addInCondition('id', $ids);
                    Product::model()->updateAll(array(
                        "condition" => $newIndex
                    ), $updateCriteria);
                }
            }
        }
        $this->render('index',array(
            'data' => $data,
        ));
    }
}