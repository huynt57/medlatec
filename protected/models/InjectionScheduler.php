<?php

Yii::import('application.models._base.BaseInjectionScheduler');

class InjectionScheduler extends BaseInjectionScheduler
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}