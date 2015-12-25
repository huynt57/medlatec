<?php

Yii::import('application.models._base.BaseDrugType');

class DrugType extends BaseDrugType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}