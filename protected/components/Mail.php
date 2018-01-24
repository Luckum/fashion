<?php

class Mail extends CApplicationComponent
{
    public function send($to, $subject, $body, $priority = 'normal', $attachment = '')
    {
        Yii::app()->mailer->ClearAllRecipients(); // clear all

        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->IsHTML(true);
//        Yii::app()->mailer->From = 'mails@n2315.com';
        Yii::app()->mailer->FromName = 'N2315';
//        Yii::app()->mailer->AddReplyTo('enquiries@n2315.com');
        Yii::app()->mailer->AddAddress($to);
        Yii::app()->mailer->Subject = $subject;
        Yii::app()->mailer->Body = $body;
        if (!empty($attachment)) {
            Yii::app()->mailer->AddAttachment($attachment);
        }

        // DEBUG
        LogHelper::log($to . ' ' . $subject . ' ' . $body);
        // END DEBUG
        
        Yii::app()->mailer->Send();
    }
}
