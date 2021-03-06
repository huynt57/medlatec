<?php

/**
 * This is the model base class for the table "tbl_ward".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Ward".
 *
 * Columns in table "tbl_ward" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $ward
 * @property integer $district
 * @property integer $province
 *
 */
abstract class BaseWard extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_ward';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Ward|Wards', $n);
	}

	public static function representingColumn() {
		return 'ward';
	}

	public function rules() {
		return array(
			array('district, province', 'numerical', 'integerOnly'=>true),
			array('ward', 'safe'),
			array('ward, district, province', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, ward, district, province', 'safe', 'on'=>'search'),
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
			'ward' => Yii::t('app', 'Ward'),
			'district' => Yii::t('app', 'District'),
			'province' => Yii::t('app', 'Province'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('ward', $this->ward, true);
		$criteria->compare('district', $this->district);
		$criteria->compare('province', $this->province);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}