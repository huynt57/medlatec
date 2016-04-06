<?php

Yii::import('application.models._base.BaseProvider');

class Provider extends BaseProvider
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}