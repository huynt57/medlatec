<?php

Yii::import('application.models._base.BasePatient');

class Patient extends BasePatient
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}