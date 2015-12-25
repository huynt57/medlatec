<?php

Yii::import('application.models._base.BaseOrderMedlatec');

class OrderMedlatec extends BaseOrderMedlatec
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}