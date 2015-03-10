<?php

/**
 * This is the model class for table "bimp_user".
 *
 * The followings are the available columns in table 'bimp_user':
 * @property integer $user_id
 * @property string $nick_name
 * @property string $email
 * @property string $mobile_no
 * @property integer $age
 * @property string $sex
 * @property integer $city_id
 * @property string $password
 * @property integer $isActive
 * @property string $created_on
 * @property string $modified_on
 */
class BimpUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bimp_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nick_name, email, mobile_no, dob, sex, city_id, password, isActive, created_on, modified_on', 'required'),
                        array('email','unique','message'=>'user_exist'),
                        array('mobile_no','unique','message'=>'user_exist'),
                        array('profile_image','file','types'=>'jpg, gif, png,jpeg','allowEmpty'=>true),
			array('age, isActive', 'numerical', 'integerOnly'=>true),
			array('nick_name, mobile_no, sex', 'length', 'max'=>20),
			array('email,city_id', 'length', 'max'=>250),
                        array('email', 'email','message'=>'invalid_email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, nick_name, email, mobile_no, age, sex, city_id,profile_image, password, isActive, created_on, modified_on', 'safe', 'on'=>'search'),
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
                    'bimpUserDetails' => array(self::BELONGS_TO, 'City', 'city_id'),
//                    'userName' => array(self::HAS_ONE, 'BimpUser', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'nick_name' => 'Nick Name',
                        'profile_image'=>'Profile Picture',
			'email' => 'Email',
			'mobile_no' => 'Mobile No',
			'age' => 'Age',
                        'dob' => 'Date of Birth',
			'sex' => 'Sex',
			'city_id' => 'City',
			'password' => 'Password',
			'isActive' => 'Status',
			'created_on' => 'Created On',
			'modified_on' => 'Modified On',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('age',$this->age);
                $criteria->compare('dob',$this->dob);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('isActive',$this->isActive);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('modified_on',$this->modified_on,true);

		return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'defaultOrder' => 'modified_on DESC',
                    ),
                ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BimpUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /*
         * This is to verify user by email.
         * $email : user email
         * @return: return user id in case of success otherwise false;
         */
        public static function getUserVerified($email)
        {
            $query="select user_id from bimp_user where email='".$email."'";
            $email= Yii::app()->db->createCommand($query)->queryAll();
            $count=count($email);
            if($count==1){
                $result['userId']=$email[0]['user_id'];
                return $result;
            }else{
                return false;
            }
            
        }
        
        /*
         * This is to get user password by email.
         * $email : user email
         * @return: user password in case of success otehrwise false
         */
        public static function getUserPassword($email)
        {
            $query="select password from bimp_user where email='".$email."'";
            $email= Yii::app()->db->createCommand($query)->queryAll();
            $count=count($email);
            if($count==1){
                $result['password']=$email[0]['password'];
                return $result;
            }else{
                return false;
            }
            
        }
        
        /*
         * This is to validate user for login
         * $email= user email
         * $password= user password
         * @return : is credentials matches,return true otherwise false
         */
        public function userCheckMailLogin($email,$password)
        {
            $query="select user_id from bimp_user where email='".$email."' and password='".$password."'";
            $user= Yii::app()->db->createCommand($query)->queryAll();
            $count=count($user);
            if($count==1){
                return true;
            }else{
                return false;
            }
        }
        
        /*
         * This is to get user profile information
         * $userId = user id
         * @return : user details array in case of success otherwise false
         */
        public static function getUserProfile($userid)
        {
            $query="select user_id, nick_name,profile_image, email, dob as age, sex, city_id from bimp_user where user_id='".$userid['user_id']."'";
            $result= Yii::app()->db->createCommand($query)->queryRow();
            $count=count($result);
            if($count>0){
                return $result;
            }else{
                return false;
            }
        }
        
        
}
