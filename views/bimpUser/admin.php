<?php
/* @var $this BimpUserController */
/* @var $model BimpUser */
/* This will list all the users*/
?>
<br/>
<section>
    <h4 class="page-header-heading">&nbsp;&nbsp;Manage Users</h4>
    <p class="add_player" style="float:right;  padding-left: 12px; margin-top: 0px;"><a href="create">Create New</a></p>
</section>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bimp-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nick_name',
                'email',
		'mobile_no',
		array(
                    'name'=>'dob',
                    'value'=>function($data){
                        return date('d-m-Y',strtotime($data['dob']));
                    }
                ),
                /*
                array(
                    'name'=>'sex',
                    'filter'=>CHtml::dropDownList('sex', '',  
                        array(
                            ''=>'All',
                            'male'=>'Male',
                            'female'=>'Female',
                        )
                    ),
                ),*/
                'sex',
                array(
                    'name'=>'dob',
                    'value'=>function($data){
                        return ucfirst($data['sex']);
                    }
                ),
                
		array(
                    'name'=>'city_id',
                    'value'=>'$data->bimpUserDetails->city_name',
                    'filter' => CHtml::listData(City::model()->findAll(), 'city_id', 'city_name'),
                ),
//                array(
//                    'name'=>'isActive',
//                    'value'=>'($data->isActive == 1) ? "Active" : "In-Active"',
//                    'filter'=>CHtml::dropDownList('isActive', '',  
//                        array(
//                            ''=>'All',
//                            '0'=>'In-Active',
//                            '1'=>'Active',
//                        )
//                    ),
//                ),
                array(
                    'name'=>'profile_image',
                    'type' => 'html',
                    'filter'=>false,
                    'value'=>  function($data){
                        $imageStr=AppHelper::checkAndDisplayImageExist($data->profile_image,'profile');
                        if(!empty($imageStr)){
                            return $imageStr['imageStr'];
                        }else{
                            return '';
                        }
                    }
                ),
                array(
                    'name' => 'isActive',
                    'value' => 'Yii::t("main", $data->isActive?"Active":"Inactive")',
                    'filter' => array(Yii::t('main', 'Inactive'), Yii::t('main', 'Active')),
                    'htmlOptions' => array('width' => '70px'),
                ),

                array(
                    'class' => 'EButtonColumnWithClearFilters',
                    'header'=>'Actions',
                    'htmlOptions' => array('class' => 'alignLeft td-col-img','style'=> 'width:100px;'),
                    'template' => '{view}{update}{delete}{Activate}{Inactivate}',
                    'buttons'=>array(
                        'Activate' => array(
                            'visible'=>'$data->isActive==0',
                            'url'=>'Yii::app()->createUrl("BimpUser/updateStatus?flag=1&id=$data->user_id")',
                            'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
                        ),
                        'Inactivate' => array(
                            'visible'=>'$data->isActive==1',
                            'url'=>'Yii::app()->createUrl("BimpUser/updateStatus?flag=0&id=$data->user_id")',
                            'imageUrl'=>Yii::app()->baseUrl.'/images/inactive.jpeg',
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 100px; text-align: center;',
                    ),
                ),
	),
)); 
?>
<?php 
    if(Yii::app()->user->hasFlash('createSuccess')){
        echo "<script>$(document).ready(function(){ createMaskWithMessage('".Yii::app()->user->getFlash('createSuccess')."')});</script>";
    }  
?>
<script>
    setMainMenuTabActive('bimpUser');
</script>