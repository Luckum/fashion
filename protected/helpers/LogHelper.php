<?php
class LogHelper{
    public static function log($message){
        Yii::log($message . ' - ' . date('h-i-s') . '/' . round(microtime(true) * 1000), 'info', 'sell');
    }
}