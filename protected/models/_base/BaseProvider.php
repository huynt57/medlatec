<?php

/**
 * This is the model base class for the table "tbl_provider".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Provider".
 *
 * Columns in table "tbl_provider" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $provider_id
 * @property string $provider_name
 * @property string $provider_address
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $provider_description
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $image
 * @property integer $active
 * @property string $password
 *
 */
abstract class BaseProvider extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_provider';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Provider|Providers', $n);
	}

	public static function representingColumn() {
		return 'provider_name';
	}

	public function rules() {
		return array(
			array('created_at, updated_at, active', 'numerical', 'integerOnly'=>true),
			array('provider_name, email, phone, fax, image', 'length', 'max'=>255),
			array('provider_address, provider_description, password', 'safe'),
			array('provider_name, provider_address, created_at, updated_at, provider_description, email, phone, fax, image, active, password', 'default', 'setOnEmpty' => true, 'value' => null),
			array('provider_id, provider_name, provider_address, created_at, updated_at, provider_description, email, phone, fax, image, active, password', 'safe', 'on'=>'search'),
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
			'provider_id' => Yii::t('app', 'Provider'),
			'provider_name' => Yii::t('app', 'Provider Name'),
			'provider_address' => Yii::t('app', 'Provider Address'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'provider_description' => Yii::t('app', 'Provider Description'),
			'email' => Yii::t('app', 'Email'),
			'phone' => Yii::t('app', 'Phone'),
			'fax' => Yii::t('app', 'Fax'),
			'image' => Yii::t('app', 'Image'),
			'active' => Yii::t('app', 'Active'),
			'password' => Yii::t('app', 'Password'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('provider_id', $this->provider_id);
		$criteria->compare('provider_name', $this->provider_name, true);
		$criteria->compare('provider_address', $this->provider_address, true);
		$criteria->compare('created_at', $this->created_at);
		$criteria->compare('updated_at', $this->updated_at);
		$criteria->compare('provider_description', $this->provider_description, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('fax', $this->fax, true);
		$criteria->compare('image', $this->image, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('password', $this->password, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}