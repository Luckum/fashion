<?php
class ModalFlash extends CWidget {

    public $message = '';
    public $isShow = false;
    public $id = '';
    public $acceptableFlashes = [];
 
    public function run() {
        $messages = [];
        $app = Yii::app();

        if (isset($app->user) && $app->user) {
            $flashes = $app->user->getFlashes();
            foreach ($flashes as $key => $message) {
                if (!empty($this->acceptableFlashes) && !in_array($key, $this->acceptableFlashes)) continue;
                $messages[] = $message;
            }
        }
        
        if (isset($app->member) && $app->member) {
            $flashes = $app->member->getFlashes();
            foreach ($flashes as $key => $message) {
                if (!empty($this->acceptableFlashes) && !in_array($key, $this->acceptableFlashes)) continue;
                $messages[] = $message;
            }
        }

        $this->message = implode('<br />', $messages);
        $this->isShow = (count($messages) > 0);
        $this->id = uniqid('modal_flash_');

        $this->render('_flash');
    } 
}
?>