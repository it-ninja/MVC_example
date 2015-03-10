<?php

class BimpUserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/bimp', meaning
	 * See 'protected/views/layouts/bimp.php'.
	 */
	public $layout='bimp';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
            return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            
            //let me assign model for the data to be inserted
            $model=new BimpUser;
            $error='';
            if(isset($_POST['BimpUser']))
            {       
                //now assign valu from the form to the apecific model as per the database fields
                $model->modified_on=date('Y-m-d H:i:s');
                $model->created_on=date('Y-m-d H:i:s');
                $model->attributes=(isset($_POST['BimpUser'])?:null);
                $model->dob=date('Y-m-d',strtotime((isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['dob']:'')));
                $model->age=date('Y')-date('Y',strtotime((isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['dob']:'')));
                $model->password=md5((isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['password']:''));
                $model->profile_image=(isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['profileImageName']:'');
                //now insert the data into database
                if($model->save()){
                    //set a success message
                    Yii::app()->user->setFlash('createSuccess','User added successfully');
                    //redirect to the add form
                    $this->redirect(array('create','id'=>$model->user_id));
                }else{
                    $error='Unable to insert user data due to some technical error';
                }
            }
            //now render the specified view with the required message
            $this->render('create',array(
                    'error'=>$error,
                    'model'=>$model,
            ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            //let me assign model for the data to be inserted
            $error='';
            $model=$this->loadModel($id);

            if(isset($_POST['BimpUser']))
            {
                //now assign valu from the form to the apecific model as per the database fields
                $model->modified_on=date('Y-m-d H:i:s');
                $model->attributes=(isset($_POST['BimpUser'])?:null);
                $model->dob=date('Y-m-d',strtotime((isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['dob']:'')));
                $model->age=date('Y')-date('Y',strtotime((isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['dob']:'')));
                $model->profile_image=(isset($_POST['BimpUser']['dob'])?$_POST['BimpUser']['profileImageName']:'');
                //now update the data into database
                if($model->save()){
                    //set a success message
                    Yii::app()->user->setFlash('createSuccess','User updated successfully');
                    //redirect to the the list
                    $this->redirect(array('admin','id'=>$model->user_id));
                }
            }

            $this->render('update',array(
                    'model'=>$model,
            ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of user to be deleted
	 */
	public function actionDelete($id)
	{
            //list all the tables in an array from which we am to delete the user
            $deleteTable=array(
                            'user_personalized_message',
                            'user_notifications',
                            'user_favorite_brand',
                            'user_brand_read_status',
                            'contact_us'

            );
            //this is for deleteing the user one by one from all the above listed tables.
            foreach($deleteTable as $table){
                Yii::app()->db->createCommand('delete from '.$table.' where user_id = '.$id.'')->query();
            }
            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BimpUser');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $model=new BimpUser('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['BimpUser']))
                    $model->attributes=$_GET['BimpUser'];
            $this->render('admin',array(
                    'model'=>$model,
            ));
                
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BimpUser the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BimpUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        
	/**
	 * Performs the AJAX validation.
	 * @param BimpUser $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bimp-user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /*
         * This is to update user status like active/inactive and delete
         */
        public function actionUpdateStatus()
        {
            //collest all the values from the request
            if(isset($_GET) && isset($_GET['flag']) && isset($_GET['id'])){
                $id=$_GET['id'];
                $flag=$_GET['flag'];
                $model=BimpUser::model()->findByPk($id);
                //define the message and values regarding to the actions for different status.
                if($flag==1){
                    $model->isActive='1';
                    Yii::app()->user->setFlash('createSuccess','User activated successfully');
                }else if($flag==0){
                    Yii::app()->user->setFlash('createSuccess','User inactivated successfully');
                    $model->isActive='0';
                }
                $model->modified_on=date('Y-m-d H:i:s');
                //now update it into daatabase
                if($model->update()){
                    // in case of success redirect to the list
                    $this->redirect(array('admin','selectedId'=>$id));
                }else{
                    $this->render('update',array(
                            'model'=>$model,
                            'error'=>'Unable to update due to some technical issue.',
                    ));
                }
            }
        }
        
        /*
         * This function will be called before any action of this class we be invoked.
         * This is mainly to check user session i.e. is user logged in of we are just hitting the url of any action without login.
         */
        public function beforeAction()
        {
            if(Yii::app()->session['isLogin'] && Yii::app()->session['isLogin']==1){
                return true;
            }else{
                Yii::app()->user->setFlash('notification','Your session has been expired please login again');
                $this->redirect(array('admin/logout'));
            }
        }
        
        /*
         * This is to upload user image to the specified path
         */
        public function actionUploadImage()
        {
            //first check is there any error in the file or not
            if ( 0 < $_FILES['file']['error'] ) {
                // in case of error show the exact error
                echo 'Error: ' . $_FILES['file']['error'] . '<br>';
            }
            else {
                //first find all the information of the file and manage its identificatin features as per our need
                $fileArr=  pathinfo($_FILES['file']['name']);
                $fileName=$fileArr['filename']."_".date('ymdHis').".".$fileArr['extension']; // create unique file name
                $imagePath=Yii::app()->basePath.'/../images/profileImage/';
                //now move the contant of the file to the specfied path.
                if(move_uploaded_file($_FILES['file']['tmp_name'], $imagePath .$fileName)){
                    //return the file name
                    echo $fileName;
                }else{
                    //return error message
                    echo 'Unable to move file to the specified location';
                }
            }
        }
        
        /*
         * This is to remove the profile image of any user
         */
        public function actionRemoveProfileImage()
        {
            //collect the information from the posted form
            $id=$_POST['imageId'];
            $model=new BimpUser;//initialize model
            $RemoveLogo=BimpUser::model()->findByPk($id);
            if($RemoveLogo){
                //here we are just updating the file name with blank 
                //we are deleteing the file from the location so that we can manage the history of profile images as the list is stored in some other tables
                $RemoveLogo->profile_image='';
                $RemoveLogo->modified_on=date('Y-m-d H:i:s');
                if($RemoveLogo->update()){
                    echo "success";
                }else{
                    echo "fail";
                }
            }else{
                echo "fail";
            }
        }
}
