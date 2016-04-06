<?php

/**
 * This is the model base class for the table "tbl_provider_staff".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProviderStaff".
 *
 * Columns in table "tbl_provider_staff" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatar
 *
 */
abstract class BaseProviderStaff extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_provider_staff';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ProviderStaff|ProviderStaff', $n);
	}

	public static function representingColumn() {
		return 'email';
	}

	public function rules() {
		return array(
			array('created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('email, username, password, role, avatar', 'length', 'max'=>255),
			array('email, username, password, role, created_at, updated_at, avatar', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, email, username, password, role, created_at, updated_at, avatar', 'safe', 'on'=>'search'),
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
			'email' => Yii::t('app', 'Email'),
			'username' => Yii::t('app', 'Username'),
			'password' => Yii::t('app', 'Password'),
			'role' => Yii::t('app', 'Role'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'avatar' => Yii::t('app', 'Avatar'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('role', $this->role, true);
		$criteria->compare('created_at', $this->created_at);
		$criteria->compare('updated_at', $this->updated_at);
		$criteria->compare('avatar', $this->avatar, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}