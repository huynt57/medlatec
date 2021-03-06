<?php

/**
 * This is the model base class for the table "tbl_order_medlatec".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OrderMedlatec".
 *
 * Columns in table "tbl_order_medlatec" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $ward
 * @property string $province
 * @property string $district
 * @property string $requirement
 * @property integer $status
 * @property integer $active
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_meboo
 * @property integer $service_id
 * @property integer $time_confirm
 * @property integer $time_meet
 * @property string $price
 * @property integer $provider_id
 *
 */
abstract class BaseOrderMedlatec extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_order_medlatec';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'OrderMedlatec|OrderMedlatecs', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('status, active, created_at, updated_at, user_meboo, service_id, time_confirm, time_meet, provider_id', 'numerical', 'integerOnly'=>true),
			array('name, phone, email, ward, province, district', 'length', 'max'=>255),
			array('address, requirement, price', 'safe'),
			array('name, phone, email, address, ward, province, district, requirement, status, active, created_at, updated_at, user_meboo, service_id, time_confirm, time_meet, price, provider_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, phone, email, address, ward, province, district, requirement, status, active, created_at, updated_at, user_meboo, service_id, time_confirm, time_meet, price, provider_id', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('app', 'Name'),
			'phone' => Yii::t('app', 'Phone'),
			'email' => Yii::t('app', 'Email'),
			'address' => Yii::t('app', 'Address'),
			'ward' => Yii::t('app', 'Ward'),
			'province' => Yii::t('app', 'Province'),
			'district' => Yii::t('app', 'District'),
			'requirement' => Yii::t('app', 'Requirement'),
			'status' => Yii::t('app', 'Status'),
			'active' => Yii::t('app', 'Active'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'user_meboo' => Yii::t('app', 'User Meboo'),
			'service_id' => Yii::t('app', 'Service'),
			'time_confirm' => Yii::t('app', 'Time Confirm'),
			'time_meet' => Yii::t('app', 'Time Meet'),
			'price' => Yii::t('app', 'Price'),
			'provider_id' => Yii::t('app', 'Provider'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('ward', $this->ward, true);
		$criteria->compare('province', $this->province, true);
		$criteria->compare('district', $this->district, true);
		$criteria->compare('requirement', $this->requirement, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('active', $this->active);
		$criteria->compare('created_at', $this->created_at);
		$criteria->compare('updated_at', $this->updated_at);
		$criteria->compare('user_meboo', $this->user_meboo);
		$criteria->compare('service_id', $this->service_id);
		$criteria->compare('time_confirm', $this->time_confirm);
		$criteria->compare('time_meet', $this->time_meet);
		$criteria->compare('price', $this->price, true);
		$criteria->compare('provider_id', $this->provider_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}