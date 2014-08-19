<?php

/**
 * This is the model class for table "login_user".
 *
 * The followings are the available columns in table 'login_user':
 * @property integer $user_id
 * @property string $user_name
 * @property string $nick_name
 * @property string $e_mail
 * @property string $gender
 * @property string $birthday
 * @property integer $score
 * @property string $login_passwd
 * @property string $mapid
 * @property string $confirmed
 * @property string $account_level
 * @property string $write_off
 * @property string $freeze
 * @property string $image_url
 */
class LoginUserAr extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoginUserAr the static model class
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
		return 'login_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('score', 'numerical', 'integerOnly'=>true),
			array('user_name, nick_name, birthday', 'length', 'max'=>20),
			array('e_mail, login_passwd', 'length', 'max'=>50),
            array('mapid', 'length', 'max'=>11),
            array('gender', 'length', 'max'=>2),
            array('confirmed, write_off, freeze', 'length', 'max'=>1),
            array('account_level', 'length', 'max'=>10),
			array('image_url', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_name, nick_name, e_mail, gender, birthday, score, login_passwd, mapid, confirmed, account_level, write_off, freeze, image_url', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'user_name' => 'User Name',
			'nick_name' => 'Nick Name',
			'e_mail' => 'E Mail',
			'gender' => 'Gender',
			'birthday' => 'Birthday',
			'score' => 'Score',
			'login_passwd' => 'Login Passwd',
			'mapid' => 'Mapid',
			'confirmed' => 'Confirmed',
			'account_level' => 'Account Level',
			'write_off' => 'Write Off',
			'freeze' => 'Freeze',
			'image_url' => 'Image Url',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('e_mail',$this->e_mail,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('login_passwd',$this->login_passwd,true);
		$criteria->compare('mapid',$this->mapid);
		$criteria->compare('confirmed',$this->confirmed,true);
		$criteria->compare('account_level',$this->account_level,true);
		$criteria->compare('write_off',$this->write_off,true);
		$criteria->compare('freeze',$this->freeze,true);
		$criteria->compare('image_url',$this->image_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}