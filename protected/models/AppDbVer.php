<?php

Yii::import('application.models._base.BaseAppDbVer');

class AppDbVer extends BaseAppDbVer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}