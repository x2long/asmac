<?php

/**
 * This is the model class for table "itf_recordlog".
 *
 * The followings are the available columns in table 'itf_recordlog':
 * @property integer $streamnumber
 * @property string $callingnumber
 * @property string $calltime
 * @property integer $recordtimes
 */
class ItfRecordlogAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItfRecordlogAr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'itf_recordlog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordtimes', 'numerical', 'integerOnly'=>true),
			array('callingnumber', 'length', 'max'=>24),
			array('calltime', 'length', 'max'=>14),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('streamnumber, callingnumber, calltime, recordtimes', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'streamnumber' => 'Streamnumber',
			'callingnumber' => 'Callingnumber',
			'calltime' => 'Calltime',
			'recordtimes' => 'Recordtimes',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('streamnumber',$this->streamnumber);
		$criteria->compare('callingnumber',$this->callingnumber,true);
		$criteria->compare('calltime',$this->calltime,true);
		$criteria->compare('recordtimes',$this->recordtimes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}