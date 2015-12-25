<?php

Yii::import('application.models._base.BaseDrug');

class Drug extends BaseDrug
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}