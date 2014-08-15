<?php

/**
 * This is the model class for table "itf_contralog".
 *
 * The followings are the available columns in table 'itf_contralog':
 * @property integer $streamnumber
 * @property integer $servicekey
 * @property string $callingnumber
 * @property string $callednumber
 * @property string $callingvlr
 * @property string $callinghlr
 * @property string $calledhlr
 * @property integer $ringtime
 * @property string $callbegintime
 * @property string $callendtime
 * @property integer $callduration
 * @property string $mscaddress
 * @property integer $call_result
 * @property string $cause
 */
class ItfContralogAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItfContralogAr the static model class
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
		return 'itf_contralog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('servicekey, ringtime, callduration, call_result', 'numerical', 'integerOnly'=>true),
			array('callingnumber, callednumber', 'length', 'max'=>24),
			array('callingvlr, callinghlr, calledhlr', 'length', 'max'=>6),
			array('callbegintime, callendtime', 'length', 'max'=>14),
			array('mscaddress', 'length', 'max'=>16),
			array('cause', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('streamnumber, servicekey, callingnumber, callednumber, callingvlr, callinghlr, calledhlr, ringtime, callbegintime, callendtime, callduration, mscaddress, call_result, cause', 'safe', 'on'=>'search'),
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
			'servicekey' => 'Servicekey',
			'callingnumber' => 'Callingnumber',
			'callednumber' => 'Callednumber',
			'callingvlr' => 'Callingvlr',
			'callinghlr' => 'Callinghlr',
			'calledhlr' => 'Calledhlr',
			'ringtime' => 'Ringtime',
			'callbegintime' => 'Callbegintime',
			'callendtime' => 'Callendtime',
			'callduration' => 'Callduration',
			'mscaddress' => 'Mscaddress',
			'call_result' => 'Call Result',
			'cause' => 'Cause',
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
		$criteria->compare('servicekey',$this->servicekey);
		$criteria->compare('callingnumber',$this->callingnumber,true);
		$criteria->compare('callednumber',$this->callednumber,true);
		$criteria->compare('callingvlr',$this->callingvlr,true);
		$criteria->compare('callinghlr',$this->callinghlr,true);
		$criteria->compare('calledhlr',$this->calledhlr,true);
		$criteria->compare('ringtime',$this->ringtime);
		$criteria->compare('callbegintime',$this->callbegintime,true);
		$criteria->compare('callendtime',$this->callendtime,true);
		$criteria->compare('callduration',$this->callduration);
		$criteria->compare('mscaddress',$this->mscaddress,true);
		$criteria->compare('call_result',$this->call_result);
		$criteria->compare('cause',$this->cause,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}