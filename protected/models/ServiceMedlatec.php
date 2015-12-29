<?php

Yii::import('application.models._base.BaseServiceMedlatec');

class ServiceMedlatec extends BaseServiceMedlatec {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateService($attr) {
        $result = ServiceMedlatec::model()->findByPk($attr['service_id']);
        if ($result) {
            $result->setAttributes($attr);
            $result->updated_at = time();
            if ($result->save(FALSE)) {
                return TRUE;
            }
            return FALSE;
        }
    }

    public function addService($attr) {
        $model = new ServiceMedlatec;
        $model->setAttributes($attr);
        $model->updated_at = time();
        $model->created_at = time();
        if ($model->save(FALSE)) {
            return TRUE;
        }
        return FALSE;
    }

}
