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
            $order->time_meet = StringHelper::dateToTime($attr['time_meet']);
            $order->time_confirm = StringHelper::dateToTime($attr['time_confirm']);
            $order->updated_at = time();
            if ($order->save(FALSE)) {
                $meboo = $order->user_meboo;
                //  echo $meboo; die;
                //echo $order->status; die;
                $device_tokens = DeviceTk::model()->findAllByAttributes(array('user_id' => $meboo));
                $ios_alert = null;
                if($order->status == 2)
                {
                    $ios_alert = 'Dịch vụ bạn đặt ('.ServiceMedlatec::model()->getServiceNameById($order->service_id).') đã được Meboo xác nhận';
                } else if($order->status == 4) {
                    $ios_alert = 'Dịch vụ bạn đặt ('.ServiceMedlatec::model()->getServiceNameById($order->service_id).') đã được hoàn thành';
                }
                $message_android = array('medlatec_order' =>
                    array(
                        'order_id' => $attr['order_id'],
                    ),);
                $message_ios = array(
                    'alert' => $ios_alert,
                    'sound' => 'default',
                    'data' => array(
                        'id' => $attr['order_id'],
                        'type' => '0',
                        'user_id' => $meboo,
                    )
                );
                $message = array('message_android' => $message_android, 'message_ios' => $message_ios);
                foreach ($device_tokens as $token) {
                    //  echo $token->platform; 
                    Util::sendNotificationBasedOnStatus($token->device_token, $order->status, $message);
                } //die;
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
