<?php

/**
 * This is the model base class for the table "tbl_clinics".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Clinics".
 *
 * Columns in table "tbl_clinics" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $clinic_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $lat
 * @property string $lng
 * @property string $ward
 * @property string $province
 * @property string $district
 *
 */
abstract class BaseClinics extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_clinics';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Clinics|Clinics', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, phone, lat, lng, ward, province, district', 'length', 'max'=>255),
			array('address', 'safe'),
			array('name, address, phone, lat, lng, ward, province, district', 'default', 'setOnEmpty' => true, 'value' => null),
			array('clinic_id, name, address, phone, lat, lng, ward, province, district', 'safe', 'on'=>'search'),
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
			'clinic_id' => Yii::t('app', 'Clinic'),
			'name' => Yii::t('app', 'Name'),
			'address' => Yii::t('app', 'Address'),
			'phone' => Yii::t('app', 'Phone'),
			'lat' => Yii::t('app', 'Lat'),
			'lng' => Yii::t('app', 'Lng'),
			'ward' => Yii::t('app', 'Ward'),
			'province' => Yii::t('app', 'Province'),
			'district' => Yii::t('app', 'District'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('clinic_id', $this->clinic_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('lat', $this->lat, true);
		$criteria->compare('lng', $this->lng, true);
		$criteria->compare('ward', $this->ward, true);
		$criteria->compare('province', $this->province, true);
		$criteria->compare('district', $this->district, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}