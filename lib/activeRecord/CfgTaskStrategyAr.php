<?php

/**
 * This is the model class for table "cfg_task_strategy".
 *
 * The followings are the available columns in table 'cfg_task_strategy':
 * @property integer $holiday_id
 * @property integer $fe_id
 * @property integer $act_task_id
 * @property integer $data_id
 * @property string $phone_type
 * @property integer $value
 * @property string $units
 * @property integer $check_index
 * @property integer $sus_id
 * @property string $extension_value
 * @property integer $fluctuation
 */
class CfgTaskStrategyAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CfgTaskStrategyAr the static model class
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
		return 'cfg_task_strategy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('holiday_id, fe_id, act_task_id, data_id, phone_type, value, units, check_index, sus_id', 'required'),
			array('holiday_id, fe_id, act_task_id, data_id, value, check_index, sus_id, fluctuation', 'numerical', 'integerOnly'=>true),
			array('phone_type, units, extension_value', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('holiday_id, fe_id, act_task_id, data_id, phone_type, value, units, check_index, sus_id, extension_value, fluctuation', 'safe', 'on'=>'search'),
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
			'holiday_id' => 'Holiday',
			'fe_id' => 'Fe',
			'act_task_id' => 'Act Task',
			'data_id' => 'Data',
			'phone_type' => 'Phone Type',
			'value' => 'Value',
			'units' => 'Units',
			'check_index' => 'Check Index',
			'sus_id' => 'Sus',
			'extension_value' => 'Extension Value',
			'fluctuation' => 'Fluctuation',
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

		$criteria->compare('holiday_id',$this->holiday_id);
		$criteria->compare('fe_id',$this->fe_id);
		$criteria->compare('act_task_id',$this->act_task_id);
		$criteria->compare('data_id',$this->data_id);
		$criteria->compare('phone_type',$this->phone_type,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('units',$this->units,true);
		$criteria->compare('check_index',$this->check_index);
		$criteria->compare('sus_id',$this->sus_id);
		$criteria->compare('extension_value',$this->extension_value,true);
		$criteria->compare('fluctuation',$this->fluctuation);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}