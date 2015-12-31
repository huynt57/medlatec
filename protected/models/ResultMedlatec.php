<?php

Yii::import('application.models._base.BaseResultMedlatec');

class ResultMedlatec extends BaseResultMedlatec {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateResult($attr, $urlArr) {
        $result = ResultMedlatec::model()->findByPk($attr['result_id']);
        if ($result) {
            $result->setAttributes($attr);
            //$result->file = $url;
            $result->updated_at = time();

            if (isset($urlArr)) {
                // ResultFile::model()->findAllByAttributes(array('result_id'=>$attr['result_id']))->delete();
            }
            if ($result->save(FALSE)) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    public function addResult($attr, $urlArr) {
        $model = new ResultMedlatec;
        $model->setAttributes($attr);
        $model->updated_at = time();
        $model->created_at = time();
        // $model->file = $url;
        if ($model->save(FALSE)) {
            return TRUE;
        }
        return FALSE;
    }

    public function getDetailResult($result_id) {
        $service_name = null;
        $patient_name = null;
        $result = ResultMedlatec::model()->findByPk($result_id);
        $order = OrderMedlatec::model()->findByPk($result->order_id);
        if ($order) {
            $service = ServiceMedlatec::model()->findByPk($order->service_id);
            if ($service) {
                $service_name = $service->service_name;
            }
            $patient_name = $order->name;
        }
        $returnArr = array();
        $attrLabels = $this->attributeLabels();
        foreach ($attrLabels as $key => $value) {
            $returnArr[$key] = $result->$key;
            $returnArr['patient_name_f'] = $patient_name;
            $returnArr['service_name_f'] = $service_name;
            $returnArr['email'] = $order->email;
            $returnArr['address'] = $order->address;
        }
        return $returnArr;
    }

    public function updateResultByOrder($attr, $urls) {

        $check = ResultMedlatec::model()->findByAttributes(array('order_id' => $attr['order_id']));
        if ($check) {
            $check->setAttributes($attr);
            $check->updated_at = time();
            $check->save(FALSE);
            $order = OrderMedlatec::model()->findByPk($attr['order_id']);
            $order->status = 4;
            $order->save(FALSE);
            $meboo = $order->user_meboo;
            $meboo_token = User::model()->findByPk($meboo);
            if ($meboo_token) {
                $message = array('medlatec_order' =>
                    array(
                        'order_id' => $attr['order_id'],
                    ),);
                Util::sendNotificationBasedOnStatus($meboo_token->device_token, $order->status, $message);
            }
            if (!empty($urls) && is_array($urls)) {
                $files = ResultFile::model()->findAllByAttributes(array('result_id' => $check->id));
                if ($files) {
                    foreach ($files as $file) {
                        $file->delete();
                    }
                }
                foreach ($urls as $url) {
                    $file = new ResultFile;
                    $file->url = $url;
                    $file->updated_at = time();
                    $file->created_at = time();
                    $file->result_id = $check->id;
                    $file->save(FALSE);
                }
            }
            return TRUE;
        } else {
            $model = new ResultMedlatec;
            $model->setAttributes($attr);
            $model->order_id = $attr['order_id'];
            $model->created_at = time();
            $model->updated_at = time();
            $model->save(FALSE);
            $order = OrderMedlatec::model()->findByPk($attr['order_id']);
            $order->status = 4;
            $order->save(FALSE);
            $meboo = $order->user_meboo;
            $meboo_token = User::model()->findByPk($meboo);
            if ($meboo_token) {
                $message = array('medlatec_order' =>
                    array(
                        'order_id' => $attr['order_id'],
                    ),);
                Util::sendNotificationBasedOnStatus($meboo_token->device_token, $order->status, $message);
            }
            if (!empty($urls) && is_array($urls)) {
                foreach ($urls as $url) {
                    $file = new ResultFile;
                    $file->url = $url;
                    $file->updated_at = time();
                    $file->created_at = time();
                    $file->result_id = $model->id;
                    $file->save(FALSE);
                }
            }
            return TRUE;
        }
    }

}
