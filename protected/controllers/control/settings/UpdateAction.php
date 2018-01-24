<?php
/**
 * Settings (Base and Billing)
 */
class UpdateAction extends CAction
{
    private $modelName = 'Settings';
    
	public function __construct($controller, $id)
    {
    	parent::__construct($controller, $id);
    	
    	if (isset($this->controller->settingsModelName)) {
    		$this->modelName = $this->controller->settingsModelName;
    		Yii::import($this->controller->settingsModelPath);
    	}
    }
    
	public function run()
    {
    	$model  = new $this->modelName;
		if (Yii::app()->request->isPostRequest && !empty($_POST[$this->modelName])) {
        	$model->setAttributes($_POST[$this->modelName]);
            if ($model->validate()) {
            	if ($model->save()) {
            		Yii::app()->user->setFlash(
                        'success', Yii::t('base', 'Settings have been updated successfully'));
            	}
            	//@todo fix "redirect" (If the controller belongs to a module, module ID will be prefixed to the route)           	
				$module = Yii::app()
                    ->getController()
                    ->getModule() ? '/' . $this->controller->module->id : '';

                $this->controller->redirect(array(
                    $module . '/' . str_replace('admin/','',$this->controller->id)
                ));
            }
        }
        $this->controller->render('update', array(
            'model' => $model, 'settings' => $model->getSettings()
        ));
    }
}