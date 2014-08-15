<?php

/**
 * This is the model class for table "ser_inter_black".
 *
 * The followings are the available columns in table 'ser_inter_black':
 * @property integer $stream_number
 * @property string $commit_time
 * @property string $phone_number
 * @property integer $phone_type
 * @property integer $illegal_reason
 * @property string $reason_desc
 * @property integer $illegal_type
 * @property integer $intercept_times
 * @property string $intercept_valid
 * @property string $seg_flag
 * @property string $triger_area
 * @property integer $service_key
 */
class SerInterBlackAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SerInterBlackAr the static model class
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
		return 'ser_inter_black';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('commit_time, phone_number, phone_type, illegal_reason', 'required'),
			array('phone_type, illegal_reason, illegal_type, intercept_times, service_key', 'numerical', 'integerOnly'=>true),
			array('commit_time, intercept_valid', 'length', 'max'=>14),
			array('phone_number', 'length', 'max'=>21),
			array('reason_desc', 'length', 'max'=>100),
			array('seg_flag', 'length', 'max'=>1),
			array('triger_area', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stream_number, commit_time, phone_number, phone_type, illegal_reason, reason_desc, illegal_type, intercept_times, intercept_valid, seg_flag, triger_area, service_key', 'safe', 'on'=>'search'),
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
			'stream_number' => 'Stream Number',
			'commit_time' => 'Commit Time',
			'phone_number' => 'Phone Number',
			'phone_type' => 'Phone Type',
			'illegal_reason' => 'Illegal Reason',
			'reason_desc' => 'Reason Desc',
			'illegal_type' => 'Illegal Type',
			'intercept_times' => 'Intercept Times',
			'intercept_valid' => 'Intercept Valid',
			'seg_flag' => 'Seg Flag',
			'triger_area' => 'Triger Area',
			'service_key' => 'Service Key',
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

		$criteria->compare('stream_number',$this->stream_number);
		$criteria->compare('commit_time',$this->commit_time,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('phone_type',$this->phone_type);
		$criteria->compare('illegal_reason',$this->illegal_reason);
		$criteria->compare('reason_desc',$this->reason_desc,true);
		$criteria->compare('illegal_type',$this->illegal_type);
		$criteria->compare('intercept_times',$this->intercept_times);
		$criteria->compare('intercept_valid',$this->intercept_valid,true);
		$criteria->compare('seg_flag',$this->seg_flag,true);
		$criteria->compare('triger_area',$this->triger_area,true);
		$criteria->compare('service_key',$this->service_key);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}