<?php

Yii::import('application.models._base.BasePatientSick');

class PatientSick extends BasePatientSick
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}