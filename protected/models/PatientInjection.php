<?php

Yii::import('application.models._base.BasePatientInjection');

class PatientInjection extends BasePatientInjection
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}