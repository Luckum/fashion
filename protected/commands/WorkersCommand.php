<?php

/**
 * Консольная команда для работы с воркерами Gearman.
 */
class WorkersCommand extends CConsoleCommand
{
    /**
     * Отправка письма.
     */
    public function actionSendMail()
    {
        // Создаем экземпляр обработчика.
        $worker = new GearmanWorker();
        // Добавляем сервер заданий по умолчанию (localhost).
        $worker->addServer();
        // Добавляем функцию обратного вызова.
        $worker->addFunction('SendMail', function($job) {
            $workload = $job->workload();
            $data = json_decode($workload, true);

            $to = isset($data['to']) ? $data['to'] : '';
            $subject = isset($data['subject']) ? $data['subject'] : '';
            $body = isset($data['body']) ? $data['body'] : '';
            $attachment = isset($data['attachment']) ? $data['attachment'] : '';

            if (empty($to)) return;

            Yii::app()->mailer->ClearAllRecipients();
            Yii::app()->mailer->IsSMTP();
            Yii::app()->mailer->IsHTML(true);
            Yii::app()->mailer->CharSet = 'UTF-8';
            Yii::app()->mailer->From = 'mails@23-15.com';
            Yii::app()->mailer->FromName = '23-15';
            Yii::app()->mailer->AddReplyTo('enquiries@23-15.com');
            Yii::app()->mailer->AddAddress($to);
            Yii::app()->mailer->addCustomHeader('List-Unsubscribe: <http://www.23-15.com/unsubscribe>');
            Yii::app()->mailer->Subject = $subject;
            Yii::app()->mailer->Body = $body;
            Yii::app()->mailer->AltBody = strip_tags($body);
            if (!empty($attachment)) {
                Yii::app()->mailer->AddAttachment($attachment);
            }

            try {
                Yii::app()->mailer->Send();
            } catch (Exception $e) {
                Yii::app()->mailer->Send();
            }
        });
        // Запускаем обработчик, ожидающий заданий от сервера.
        while ($worker->work());
    }
}