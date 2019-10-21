<?php

/**
 * This is the model class for table "cron_job".
 *
 * The followings are the available columns in table 'cron_job':
 * @property integer $id
 * @property string $command
 * @property string $last_run
 * @property integer $time_run
 *
 */
class CronJob extends CActiveRecord
{
    const TIME_RUN_NIGHT = 1;
    const TIME_RUN_DAY = 2;
    const TIME_RUN_EVENING = 3;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cron_job';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('command, last_run', 'required'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Country the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
