<?php

Yii::import('application.models._base.BaseSick');

class Sick extends BaseSick
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}