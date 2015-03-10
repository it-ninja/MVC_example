<?php
/* @var $this BimpUserController */
/* @var $model BimpUser */
/* This is to invoke user details view page*/
?>
<br/>
<section>
    <h4 class="page-header-heading">&nbsp;&nbsp;View User Details</h4>
    <p class="add_player" style="float:right;  padding-left: 12px; margin-top: 0px;">
    <?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/images/homeList.jpeg" title="Manage Users">','admin',array('class'=>'floatRight')); ?></p>
    
</section>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nick_name',
		'email',
		'mobile_no',
		array(
                    'name'=>'dob',
                    'value'=>function($data){
                        return date('d-m-Y',strtotime($data['dob']));
                    }
                ),
		'sex',
		'city_id',
                array(
                    'name'=>'profile_image',
                    'type' => 'html',
                    'value'=>  function($data){
                        $img=AppHelper::checkAndDisplayImageExist($data->profile_image,'profile');
                        if($img){
                            return $img['imageStr'];
                        }else{
                            return "";
                        }
                    }
                ),
		array(
                    'name'=>'isActive',
                    'value'=>$model->isActive?"Active":"In-Active",
                ),
	),
)); ?>
<p class="add_player" style="float:right;  padding-left: 12px; margin-top: 0px;"><a href="admin">Cancel</a></p>
<br/>
<script>
    setMainMenuTabActive('bimpUser');
</script>