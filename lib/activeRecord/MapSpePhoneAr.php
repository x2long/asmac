<?php

/**
 * This is the model class for table "map_spe_phone".
 *
 * The followings are the available columns in table 'map_spe_phone':
 * @property integer $stream_number
 * @property string $phone
 * @property integer $phone_type
 * @property string $name
 * @property string $province
 * @property string $city
 * @property integer $match_type
 * @property integer $minsusphonelen
 * @property integer $status
 */
class MapSpePhoneAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MapSpePhoneAr the static model class
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
		return 'map_spe_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phone, phone_type, match_type, status', 'required'),
			array('phone_type, match_type, minsusphonelen, status', 'numerical', 'integerOnly'=>true),
			array('phone', 'length', 'max'=>21),
			array('name', 'length', 'max'=>100),
			array('province', 'length', 'max'=>20),
			array('city', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stream_number, phone, phone_type, name, province, city, match_type, minsusphonelen, status', 'safe', 'on'=>'search'),
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
			'phone' => 'Phone',
			'phone_type' => 'Phone Type',
			'name' => 'Name',
			'province' => 'Province',
			'city' => 'City',
			'match_type' => 'Match Type',
			'minsusphonelen' => 'Minsusphonelen',
			'status' => 'Status',
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('phone_type',$this->phone_type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('match_type',$this->match_type);
		$criteria->compare('minsusphonelen',$this->minsusphonelen);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}