<?php

Yii::import('application.models._base.BaseOrderMedlatec');

class OrderMedlatec extends BaseOrderMedlatec {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateOrder($attr) {
        $order = OrderMedlatec::model()->findByPk($attr['order_id']);
        if ($order) {
            $order->setAttributes($attr);
            $order->updated_at = time();
            if ($order->save(FALSE)) {
                $meboo = $order->user_meboo;
                $meboo_token = User::model()->findByPk($meboo)->device_token;
                if ($meboo_token) {
                    Util::sendNotificationBasedOnStatus($meboo_token, $order->status);
                }
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getOrderDetail($order_id) {
        $order = OrderMedlatec::model()->findByPk($order_id);
        $attrs = $this->attributeLabels();
        $itemArr = array();
        foreach ($attrs as $key => $value) {
            $itemArr[$key] = $order->$key;
        }
        $service = ServiceMedlatec::model()->findByPk($order->service_id);

        if (!empty($service)) {
            $service_name = $service->service_name;
        } else {
            $service_name = null;
        }
        $itemArr['service_name'] = $service_name;

        return $itemArr;
    }

}
