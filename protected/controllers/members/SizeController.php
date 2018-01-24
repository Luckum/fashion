<?php
/**
 * Class SizeController
 */
class SizeController extends MemberController
{
    /**
     * Список размеров для указанной подкатегории товаров.
     */
	public function actionGetSizeListForSubCat()
	{
        // Проверяем входные параметры.
        if (empty($_POST['category']) || !is_numeric($_POST['category'])) {
            throw new CHttpException(400, 'Bad Request');
        }
        $html = isset($_POST['type']) && $_POST['type'] == 'size' ?
            $this -> getSizeHtml($_POST['category']) : $this -> getSizeHtml();

        // Возвращаем ответ.
        die($html);
	}

    public function actionGetSizeListForSubCatAndAttributes()
    {
        // Проверяем входные параметры.
        if (empty($_POST['category']) || !is_numeric($_POST['category'])) {
            throw new CHttpException(400, 'Bad Request');
        }

        $uikitDesign = isset($_POST['uikit']) ? ($_POST['uikit'] == "true") : true;

        $html = $this->getSizeHtml();
        $attributesHtml = AttributeHelper::renderAttributesByCategoryId(intval($_POST['category']), $uikitDesign, false);
        
        // Возвращаем ответ.
        die(json_encode(array(
            'size_type' => $html, 
            'attributes' => $attributesHtml
            ))
        );
    } 

    private function getSizeHtml($size_chart_cat_id = null)
    {
        // Получаем список размеров для данной категории товаров.
        if (is_null($size_chart_cat_id)) {
            $size_chart_cat_id = Category :: model()
                -> findAllByPk($_POST['category'])[0]['size_chart_cat_id'];
        }
        $sizes = SizeChart :: model() -> findAllByAttributes(array(
           'size_chart_cat_id' => $size_chart_cat_id));

        // Разбиваем размеры по категориям.
        $categorized = array();
        foreach ($sizes as $item) {
           if (!isset($categorized[$item -> type])) {
               $categorized[$item -> type] = array();
           }
           $categorized[$item -> type][] = array(
               $item -> id,
               $item -> size
           );
        }

        // Генерируем список с разбиением по категориям (optgroup).
        $html = CHtml :: tag('option', array('value' => ''),
           CHtml :: encode(Yii :: t('base', 'select size')), true);
        foreach ($categorized as $key => $data) {
           $html .= '<optgroup label="' . $key . '">';
           foreach ($data as $option) {
               $html .= CHtml :: tag('option', array('value' => $option[0]),
                   $option[1], true);
           }
           $html .= '</optgroup>';
        }
        return $html;
    }   
}