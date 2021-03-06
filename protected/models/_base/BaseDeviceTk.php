<?php

/**
 * This is the model base class for the table "tbl_device_tk".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DeviceTk".
 *
 * Columns in table "tbl_device_tk" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $device_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $time_to_live
 * @property integer $status
 * @property integer $user_id
 * @property string $platform
 *
 */
abstract class BaseDeviceTk extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_device_tk';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DeviceTk|DeviceTks', $n);
	}

	public static function representingColumn() {
		return 'device_token';
	}

	public function rules() {
		return array(
			array('created_at, updated_at, time_to_live, status, user_id', 'numerical', 'integerOnly'=>true),
			array('platform', 'length', 'max'=>255),
			array('device_token', 'safe'),
			array('device_token, created_at, updated_at, time_to_live, status, user_id, platform', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, device_token, created_at, updated_at, time_to_live, status, user_id, platform', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'device_token' => Yii::t('app', 'Device Token'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'time_to_live' => Yii::t('app', 'Time To Live'),
			'status' => Yii::t('app', 'Status'),
			'user_id' => Yii::t('app', 'User'),
			'platform' => Yii::t('app', 'Platform'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('device_token', $this->device_token, true);
		$criteria->compare('created_at', $this->created_at);
		$criteria->compare('updated_at', $this->updated_at);
		$criteria->compare('time_to_live', $this->time_to_live);
		$criteria->compare('status', $this->status);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('platform', $this->platform, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}