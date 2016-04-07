<?php

Yii::import('application.models._base.BaseProvider');

class Provider extends BaseProvider {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProviderName($provider_id) {
        $provider = Provider::model()->findByPk($provider_id);
        if ($provider) {
            return $provider->provider_name;
        }
        return 'Medlatec';
    }

}
