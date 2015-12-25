<?php

Yii::import('application.models._base.BaseReview');

class Review extends BaseReview
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}