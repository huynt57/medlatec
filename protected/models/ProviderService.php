<?php

Yii::import('application.models._base.BaseProviderService');

class ProviderService extends BaseProviderService
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}