<?php

/**
 * This is the model class for table "ser_inter_called_info".
 *
 * The followings are the available columns in table 'ser_inter_called_info':
 * @property integer $stream_number
 * @property string $commit_time
 * @property string $phone_number
 * @property string $called_number
 */
class SerInterCalledInfoAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SerInterCalledInfoAr the static model class
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
		return 'ser_inter_called_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('commit_time, phone_number, called_number', 'required'),
			array('commit_time', 'length', 'max'=>14),
			array('phone_number, called_number', 'length', 'max'=>21),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stream_number, commit_time, phone_number, called_number', 'safe', 'on'=>'search'),
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
			'called_number' => 'Called Number',
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
		$criteria->compare('called_number',$this->called_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}