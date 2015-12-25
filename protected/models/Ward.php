<?php

Yii::import('application.models._base.BaseWard');

class Ward extends BaseWard
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}