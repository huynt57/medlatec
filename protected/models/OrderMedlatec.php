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
                return TRUE;
            }
        }
        return FALSE;
    }

}
