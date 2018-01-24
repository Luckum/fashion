<?php

class AttributeHelper
{
    public static $model = null;

    protected static $uikitDesign = false;
    protected static $echoHtml = true;
    protected static $checkboxCounter = 0;

    public static function renderAttributesByCategoryId($categoryId, $_uikitDesign = false, $_echoHtml = true)
    {
        if (!is_numeric($categoryId)) return;

        self::$uikitDesign = $_uikitDesign;
        self::$echoHtml = $_echoHtml;

        $product = new Product;
        $product->category_id = $categoryId;
        $attributes = $product->arrayAttributes();

        return self::renderContent($attributes);
    }

    public static function renderAttributesByProductId($productId, $_uikitDesign = false, $_echoHtml = true)
    {
        if (!is_numeric($productId)) return;

        self::$uikitDesign = $_uikitDesign;
        self::$echoHtml = $_echoHtml;

        $attributes = Product::getProductAttributes($productId);

        return self::renderContent($attributes);
    }

    protected static function renderContent($attributes)
    {
        $content = '';
        self::$checkboxCounter = 0;

        if ($attributes) {
            $content .= self::getHeader();
        }

        foreach ($attributes as $attribute) {
            $content .= self::getHtml($attribute);
        }

        if (self::$uikitDesign) {
            $content .= '<script>if(typeof attributes_select_init != "undefined"){attributes_select_init();}</script>';
        }
        if (self::$echoHtml) {
            echo $content;
        }
        return $content;
    }

    protected static function getHeader()
    {
        $content = '';
        if (!self::$uikitDesign) {
            $content .= '<div class="row">';
            $content .= CHtml::label(Yii::t('base', 'Attributes'),'attributes');
            $content .= '</div>';
        } else {
            $content .= '<div class="uk-margin-top">';
//            $content .= '<div class="uk-margin-bottom">';
//            $content .= '<label class="uk-form-label">';
//            $content .= Yii::t('base', 'Attributes') . ' :';
//            $content .= '</label>';
//            $content .= '</div>';
            $content .= '</div>';
        }
        return $content;
    }

    protected static function getHtml($attribute)
    {
        if (isset($attribute['isActive']) && !$attribute['isActive']) return '';
        if (!self::$uikitDesign) {
            $content = '<div class="row"><div class="offset1">';
        } else {
            $content = '<div class="uk-grid uk-margin-large-top">';
            $content .= '<div class="uk-width-1-1 uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1">';
        }
        if (self::$uikitDesign) {
            $content .= '<div class="uk-form-row">';
        }

        $attributeValue = CHtml::encode($attribute['attributeName']->values);
        $labelText = $labelId = CHtml::encode($attribute['attributeName']->name);
        if (isset($attribute['isRequired']) &&
            $attribute['isRequired']        &&
            self::$uikitDesign) {
            $labelText .= "*";
        }
        $content .= CHtml::label(
            $labelText,
            $labelId,
            array('class' => 'uk-form-label')
        );
        $attributeHtmlName = "Product[Attributes][".$attribute['attributeId']."]";
        $error = $requiredData = '';
        $requiredDataAtrAr = array();
        if (self::$model && self::$model->hasErrors($attributeHtmlName)) {
            $error = CHtml::error(self::$model, $attributeHtmlName);
        }

        switch ($attribute['type']) {
            case 'textarea':
                if (isset($attribute['definedValue'])) {
                    $attributeValue = $attribute['definedValue'];
                }
                if (isset($attribute['isRequired']) && $attribute['isRequired']) {
                    $requiredData = ' data-textarea-required="1" ';
                }
               //  $content .= "<textarea name=\"".$attributeHtmlName."\" class=\"ckeditor\">".$attributeValue."</textarea>
               // <script type=\"text/javascript\">
               //  jQuery(document).ready(function($) {
               //    CKEDITOR.replace( \"".$attributeHtmlName."\" );
               //    CKEDITOR.add
               //    });
               // </script>";
                $content .= "<textarea ".$requiredData." name=\"".$attributeHtmlName."\" class=\"attributeTextarea description-textarea\">".$attributeValue."</textarea>";
                break;
            case 'dropdown':
                $attributeValue = '';
                if (isset($attribute['definedValue'])) {
                    $attributeValue = $attribute['definedValue'];
                }
                if (self::$uikitDesign) {
                    $content .= '<div class="uk-form-controls uk-form-select uk-margin-top">';
                }
                $content .= "<select ".$requiredData." class=\"js-select\" name=\"" . $attributeHtmlName . "\" >";
                $attrValues = explode(',', $attribute['attributeName']->values);
                foreach ($attrValues as $val) {
                    $selected = ($attributeValue == $val) ? "selected='selected'" : "";
                    $content .= "<option " . $selected . " value='" . CHtml::encode($val) . "'>$val</option>";
                }
                $content .= "</select>";
                if (self::$uikitDesign) {
                    $content .= "</div>";
                }
                break;
            case 'checkbox':
                $definedValues = array();
                if (isset($attribute['definedValue'])) {
                    $definedValues = explode(',', $attribute['definedValue']);
                }
                if (isset($attribute['isRequired']) && $attribute['isRequired']) {
                    $requiredData = ' data-checkboxes-required="1" ';
                }
                $attrValues = explode(',', $attribute['attributeName']->values);

                $content .= "<input value=\"\" type=\"hidden\" name=\"" . $attributeHtmlName . "[]\" />";
                $content .= "<div " . $requiredData . " class='checkboxListContainer'>";
                foreach ($attrValues as $val) {
                    if (self::$uikitDesign) {
                        $content .= "<div class=\"form-group-checkbox uk-form-controls\">";
                    }
                    $checked = (in_array($val, $definedValues)) ? "checked='checked'" : "";
                    $content .= "<input id=\"attr_checkbox_" . self::$checkboxCounter . "\" value=\"" . CHtml::encode($val) . "\" " . $checked . " type=\"checkbox\" name=\"" . $attributeHtmlName . "[]\" />";
                    if (self::$uikitDesign) {
                        $content .= "<label class=\"label-checkbox\" for=\"attr_checkbox_" . self::$checkboxCounter . "\"><span></span>". CHtml::encode($val) . "</label><br />";
                    } else {
                        $content .= CHtml::encode($val) . "<br />";
                    }
                    if (self::$uikitDesign) {
                        $content .= "</div>";
                    }
                    self::$checkboxCounter++;
                }
                $content .= "</div>";

                break;
            default:    //simple text field
                if (isset($attribute['definedValue'])) {
                    $attributeValue = $attribute['definedValue'];
                }
                if (isset($attribute['isRequired']) && $attribute['isRequired']) {
                    $requiredData = ' data-textarea-required="1" ';
                }
                if (isset($attribute['isRequired']) && $attribute['isRequired']) {
                    $requiredDataAtrAr = array('data-textbox-required' => 1);
                }
                $content .= CHtml::textField(
                    $attributeHtmlName,
                    $attributeValue,
                    $requiredDataAtrAr
                );
        }
        $content .= $error;
        if (self::$uikitDesign) {
            $content .= '</div>';
        }
        $content .= '</div></div>';
        return $content;
    }
}