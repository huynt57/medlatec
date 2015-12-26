<?php

Yii::import('application.models._base.BaseResultMedlatec');

class ResultMedlatec extends BaseResultMedlatec {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateResult($attr) {
        $result = ResultMedlatec::model()->findByPk($attr['result_id']);
        if ($result) {
            $result->setAttributes($attr);
            $result->updated_at = time();
            if ($result->save(FALSE)) {
                return TRUE;
            }
            return FALSE;
        }
    }

    public function addResult($attr) {
        $model = new ResultMedlatec;
        $model->setAttributes($attr);
        $model->updated_at = time();
        $model->created_at = time();
        if ($model->save(FALSE)) {
            return TRUE;
        }
        return FALSE;
    }

}
