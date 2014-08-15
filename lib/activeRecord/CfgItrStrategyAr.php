<?php

/**
 * This is the model class for table "cfg_itr_strategy".
 *
 * The followings are the available columns in table 'cfg_itr_strategy':
 * @property integer $strategy
 * @property string $desc
 * @property integer $value
 * @property integer $strage_stream
 */
class CfgItrStrategyAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CfgItrStrategyAr the static model class
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
		return 'cfg_itr_strategy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('strategy, value, strage_stream', 'numerical', 'integerOnly'=>true),
			array('desc', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('strategy, desc, value, strage_stream', 'safe', 'on'=>'search'),
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
			'strategy' => 'Strategy',
			'desc' => 'Desc',
			'value' => 'Value',
			'strage_stream' => 'Strage Stream',
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

		$criteria->compare('strategy',$this->strategy);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('strage_stream',$this->strage_stream);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}