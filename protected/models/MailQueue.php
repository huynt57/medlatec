<?php

Yii::import('application.models._base.BaseMailQueue');

class MailQueue extends BaseMailQueue {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function addMailQueue($message, $from_email, $from_name, $to_email, $subject) {
        $queue = new MailQueue;
        $queue->from_email = $from_email;
        $queue->from_name = $from_name;
        $queue->to_email = $to_email;
        $queue->subject = $subject;
        $queue->message = $message;
        $queue->date_published = time();
        $queue->attempts = 0;
        $queue->max_attempts = 5;
        $queue->success = 0;
        if ($queue->save(FALSE)) {
            return TRUE;
        }
        return FALSE;
    }

}
