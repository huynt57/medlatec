<?php

Yii::import('application.models._base.BaseUserPatient');

class UserPatient extends BaseUserPatient
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}