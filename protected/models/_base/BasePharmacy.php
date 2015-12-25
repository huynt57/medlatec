<?php

/**
 * This is the model base class for the table "tbl_pharmacy".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Pharmacy".
 *
 * Columns in table "tbl_pharmacy" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $laititude
 * @property string $longitude
 * @property string $state
 * @property string $contact_num
 * @property integer $type
 * @property integer $user_id
 * @property string $ward
 * @property string $province
 * @property string $district
 *
 */
abstract class BasePharmacy extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_pharmacy';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Pharmacy|Pharmacies', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('type, user_id', 'numerical', 'integerOnly'=>true),
			array('name, address, laititude, longitude, state, contact_num, ward, province, district', 'length', 'max'=>255),
			array('name, address, laititude, longitude, state, contact_num, type, user_id, ward, province, district', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, address, laititude, longitude, state, contact_num, type, user_id, ward, province, district', 'safe', 'on'=>'search'),
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
			'address' => Yii::t('app', 'Address'),
			'laititude' => Yii::t('app', 'Laititude'),
			'longitude' => Yii::t('app', 'Longitude'),
			'state' => Yii::t('app', 'State'),
			'contact_num' => Yii::t('app', 'Contact Num'),
			'type' => Yii::t('app', 'Type'),
			'user_id' => Yii::t('app', 'User'),
			'ward' => Yii::t('app', 'Ward'),
			'province' => Yii::t('app', 'Province'),
			'district' => Yii::t('app', 'District'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('laititude', $this->laititude, true);
		$criteria->compare('longitude', $this->longitude, true);
		$criteria->compare('state', $this->state, true);
		$criteria->compare('contact_num', $this->contact_num, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('ward', $this->ward, true);
		$criteria->compare('province', $this->province, true);
		$criteria->compare('district', $this->district, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}