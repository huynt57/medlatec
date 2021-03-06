<?php

/**
 * This is the model base class for the table "tbl_sick".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Sick".
 *
 * Columns in table "tbl_sick" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $for_gender
 * @property integer $count
 * @property string $sick_short_name
 *
 */
abstract class BaseSick extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_sick';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Sick|Sicks', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('for_gender, count', 'numerical', 'integerOnly'=>true),
			array('name, sick_short_name', 'length', 'max'=>255),
			array('description', 'length', 'max'=>700),
			array('name, description, for_gender, count, sick_short_name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, description, for_gender, count, sick_short_name', 'safe', 'on'=>'search'),
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
			'description' => Yii::t('app', 'Description'),
			'for_gender' => Yii::t('app', 'For Gender'),
			'count' => Yii::t('app', 'Count'),
			'sick_short_name' => Yii::t('app', 'Sick Short Name'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('for_gender', $this->for_gender);
		$criteria->compare('count', $this->count);
		$criteria->compare('sick_short_name', $this->sick_short_name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}