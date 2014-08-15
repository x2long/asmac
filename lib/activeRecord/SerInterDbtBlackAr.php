<?php

/**
 * This is the model class for table "ser_inter_dbt_black".
 *
 * The followings are the available columns in table 'ser_inter_dbt_black':
 * @property integer $stream_number
 * @property string $commit_time
 * @property string $start_time
 * @property string $end_time
 * @property string $phone_number
 * @property integer $phone_type
 * @property integer $illegal_type
 * @property string $spe_phone_desc
 * @property integer $call_times
 * @property integer $num_state
 * @property integer $illegal_reason
 * @property string $last_called
 * @property string $susdesc
 * @property string $sus_type_desc
 * @property integer $actperiod
 * @property integer $act_type
 * @property integer $fe_id
 * @property integer $findsustimes
 * @property string $ensure_time
 * @property string $last_recordtime
 * @property string $triger_area
 * @property integer $service_key
 */
class SerInterDbtBlackAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SerInterDbtBlackAr the static model class
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
		return 'ser_inter_dbt_black';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('commit_time, start_time, end_time, phone_number, phone_type, illegal_type, call_times, num_state, illegal_reason, actperiod, act_type, fe_id', 'required'),
			array('phone_type, illegal_type, call_times, num_state, illegal_reason, actperiod, act_type, fe_id, findsustimes, service_key', 'numerical', 'integerOnly'=>true),
			array('commit_time, start_time, end_time, ensure_time, last_recordtime', 'length', 'max'=>14),
			array('phone_number, last_called', 'length', 'max'=>21),
			array('spe_phone_desc', 'length', 'max'=>100),
			array('susdesc, sus_type_desc', 'length', 'max'=>50),
			array('triger_area', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stream_number, commit_time, start_time, end_time, phone_number, phone_type, illegal_type, spe_phone_desc, call_times, num_state, illegal_reason, last_called, susdesc, sus_type_desc, actperiod, act_type, fe_id, findsustimes, ensure_time, last_recordtime, triger_area, service_key', 'safe', 'on'=>'search'),
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
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'phone_number' => 'Phone Number',
			'phone_type' => 'Phone Type',
			'illegal_type' => 'Illegal Type',
			'spe_phone_desc' => 'Spe Phone Desc',
			'call_times' => 'Call Times',
			'num_state' => 'Num State',
			'illegal_reason' => 'Illegal Reason',
			'last_called' => 'Last Called',
			'susdesc' => 'Susdesc',
			'sus_type_desc' => 'Sus Type Desc',
			'actperiod' => 'Actperiod',
			'act_type' => 'Act Type',
			'fe_id' => 'Fe',
			'findsustimes' => 'Findsustimes',
			'ensure_time' => 'Ensure Time',
			'last_recordtime' => 'Last Recordtime',
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
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('phone_type',$this->phone_type);
		$criteria->compare('illegal_type',$this->illegal_type);
		$criteria->compare('spe_phone_desc',$this->spe_phone_desc,true);
		$criteria->compare('call_times',$this->call_times);
		$criteria->compare('num_state',$this->num_state);
		$criteria->compare('illegal_reason',$this->illegal_reason);
		$criteria->compare('last_called',$this->last_called,true);
		$criteria->compare('susdesc',$this->susdesc,true);
		$criteria->compare('sus_type_desc',$this->sus_type_desc,true);
		$criteria->compare('actperiod',$this->actperiod);
		$criteria->compare('act_type',$this->act_type);
		$criteria->compare('fe_id',$this->fe_id);
		$criteria->compare('findsustimes',$this->findsustimes);
		$criteria->compare('ensure_time',$this->ensure_time,true);
		$criteria->compare('last_recordtime',$this->last_recordtime,true);
		$criteria->compare('triger_area',$this->triger_area,true);
		$criteria->compare('service_key',$this->service_key);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}