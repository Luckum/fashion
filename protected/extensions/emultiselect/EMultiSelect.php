<?php
/**
 * EMultiSelect class file.
 *
 * PHP Version 5.1
 * 
 * @category Vencidi
 * @package  Widget
 * @author   Loren <wiseloren@yiiframework.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     http://www.vencidi.com/ Vencidi
 * @since    3.0
 */
Yii::import('zii.widgets.jui.CJuiWidget');
/**
 * EMultiSelect Creates Multiple Select Boxes
 *
 * @category Vencidi
 * @package  Widget
 * @author   Loren <wiseloren@yiiframework.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: 1.0
 * @link     http://www.vencidi.com/ Vencidi
 * @since    3.0
 */
class EMultiSelect extends CJuiWidget
{
    public $sortable=true;
    public $searchable=true;
    public $doubleClickable=true;
    public $animated='fast';
    public $show='slideDown';
    public $hide='slideUp';
    public $dividerLocation=0.5;
    public $width=450;
    public $height= 200;

    /**
     * Run not used...
     *
     * @return void
     */
    function run()
    {
        
    }

    /**
     * Initializes everything
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->registerScripts();
    }

    /**
     * Registers the JS and CSS Files
     *
     * @return void
     */
    protected function registerScripts()
    {
        parent::registerCoreScripts();
        $basePath=Yii::getPathOfAlias('application.extensions.emultiselect.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath);

        $cs=Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/' . 'ui.multiselect.css');

        $this->scriptUrl=$baseUrl;
        $this->registerScriptFile('ui.multiselect.js');

        $params = array(
            "sortable:".($this->sortable?"true":"false"),
            "searchable:".($this->searchable?"true":"false"),
            "doubleClickable:".($this->doubleClickable?"true":"false"),
            "animated:'".$this->animated."'",
            "show:'".$this->show."'",
            "hide:'".$this->hide."'",
            "dividerLocation:".$this->dividerLocation,
            "width:".($this->width===null?"null":$this->width),
            "height:".($this->height===null?"null":$this->height),  
        );

        $parameters = '{' .implode(',', $params). '}';
        Yii::app()->clientScript->registerScript(
            'EMultiSelect',
            '$(".multiselect").multiselect('. $parameters .');',
            CClientScript::POS_READY
        );

    }
}
?>