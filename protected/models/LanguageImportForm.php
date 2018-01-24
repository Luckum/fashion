<?php
/**
 * Language Import Form class
 */
class LanguageImportForm extends CFormModel
{
	public $file;

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        return array(
            array('file', 'file', 'types' => 'php'),
        );    
    }        
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'file'  => Yii::t('base', 'Select File'),
		);
	}
}
