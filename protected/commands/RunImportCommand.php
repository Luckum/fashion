<?php

class RunImportCommand extends CConsoleCommand
{
    public function run($args)
    {
        $date_now = (new \DateTime())->setTime(0, 0 ,0);
        
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = "time_run = " . $args[0];
        $jobs = CronJob::model()->findAll($criteria);
        
        foreach ($jobs as $job) {
            $last_run = (new \DateTime($job->last_run))->setTime(0, 0 ,0);
            $interval = $date_now->diff($last_run);
            if ($interval->days == 3) {
                $job->last_run = $date_now->format('Y-m-d');
                $job->save();
                
                exec('php /var/www/protected/cron.php ' . $job->command);
            }
        }
    }    
}