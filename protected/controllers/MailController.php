<?php

class MailController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionSendMailQueue() {
        $criteria = new CDbCriteria(array(
            'condition' => 'success=:success AND attempts < max_attempts',
            'params' => array(
                ':success' => 0,
            ),
        ));

        $queueList = MailQueue::model()->findAll($criteria);
        foreach ($queueList as $queueItem) {
            $result = EmailHelper::sendEmail($queueItem->subject, $queueItem->to_email, $queueItem->message, $queueItem->from_email, $queueItem->from_name);
            if ($result) {
                $queueItem->attempts = $queueItem->attempts + 1;
                $queueItem->success = 1;
                $queueItem->last_attempt = time();
                $queueItem->date_sent = time();
                $queueItem->save(FALSE);
            } else {
                $queueItem->attempts = $queueItem->attempts + 1;
                $queueItem->last_attempt = time();
                $queueItem->save(FALSE);
            }
        }
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
