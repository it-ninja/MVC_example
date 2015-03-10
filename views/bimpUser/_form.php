<?php
/* @var $this BimpUserController */
/* @var $model BimpUser */
/* @var $form CActiveForm */
/* This form will be worked in both mode add or edit.*/
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bimp-user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
        <div class="row">
            <span class="required" style="float:left;padding:5px 25px;">Fields with * are required.</span> 
        </div>
	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'nick_name'); ?>
            </div>
            <div class="rightCol">
		<?php echo $form->textField($model,'nick_name',array('size'=>20,'maxlength'=>20,'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'nick_name'); ?>
            </div>
	</div>
        
        <div class="row">
            <div class="leftCol">
                <?php echo $form->labelEx($model,'brand_logo'); ?>
            </div>
            <div class="rightCol">
		<?php 
                    $imageInfo=AppHelper::checkAndDisplayImageExist($model->attributes['profile_image'],'profile');
                    if($model->isNewRecord!='1'){
                        if($imageInfo['imageExist']==1){
                            echo "<span id='profileImageSec'>";
                            echo "<span style='float:left'>".$imageInfo['imageStr']."</span>";
                            echo "<span style='float:left'>".CHtml::link('x','javascript:void(0);',array('class'=>'clearLink','onclick'=>'removeProfileImage('.$model->attributes['user_id'].')'))."</span>";
                            echo "</span>";
                        }else{
                            echo "<span id='profileImageSec' class='hide'>";
                            echo "<span style='float:left'>".$imageInfo['imageStr']."</span>";
                            echo "<span style='float:left'>".CHtml::link('x','javascript:void(0);',array('class'=>'clearLink','onclick'=>'removeProfileImage('.$model->attributes['user_id'].')'))."</span>";
                            echo "</span>";
                        }
                    }else{
                        echo "<span id='profileImageSec' class='hide'>";
                        echo "<span style='float:left'>".$imageInfo['imageStr']."</span>";
                        echo "<span style='float:left'>".CHtml::link('x','javascript:void(0);',array('class'=>'clearLink','onclick'=>'removeProfileImage('.$model->attributes['user_id'].')'))."</span>";
                        echo "</span>";
                    }
                ?>
                <span style="float:left">
                    <?php echo $form->fileField($model,'profile_image'); ?>
                    <?php echo CHtml::hiddenField('profileImageName' ,(!empty($model->attributes['profile_image'])?$model->attributes['profile_image']:''),array('id' => 'profileImageName')); ?>
                    <?php echo $form->error($model,'profile_image'); ?>
                    <button type="button" id="uploadImage">Upload</button>
                </span>
            </div>
        </div>
    
	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'email'); ?>
            </div>
            <div class="rightCol">
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>250,'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'email'); ?>
            </div>
	</div>

	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'mobile_no'); ?>
            </div>
            <div class="rightCol">
		<?php echo $form->textField($model,'mobile_no',array('size'=>20,'maxlength'=>20,'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'mobile_no'); ?>
            </div>
	</div>

	<div class="row">
            <div class="leftCol">
                <?php echo $form->labelEx($model,'dob'); ?>
            </div>
            <div class="rightCol">
		<?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name'=>'BimpUser[dob]',
                            'id'=>'dob',
                            'value'=>Yii::app()->dateFormatter->format("d-MM-y",strtotime($model->dob)),
                            'options'=>array(
                                'showAnim'=>'fold',
                                'buttonImage'=>Yii::app()->baseUrl.'/images/cal.png',
                                'buttomImageOnly'=>true,
                                'buttonText'=>'Select',
                                'showOn'=>'button',
                                'dateFormat'=>'dd-mm-yy',
                                'changeMonth'=> true,
                                'changeYear'=> true,
                                'yearRange'=> '-100:+0',
                            ),
                            'htmlOptions'=>array(
                                'readonly' =>true,
                            ),
                    ));  
                ?>
                <?php echo $form->error($model,'dob'); ?>
            </div>
	</div>

	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'sex'); ?>
            </div>
            <div class="rightCol">
		<label style="display:inline;width:auto;margin:0px 10px 0px 0px;">Male: </label>
                <?php echo $form->radioButton($model,'sex',array('value'=>'male','uncheckValue'=>null)); ?>
                <label style="display:inline;width:auto;margin:0px 10px 0px 40px;">Female: </label>
                <?php echo $form->radioButton($model,'sex',array('value'=>'female','uncheckValue'=>null)); ?>
                <?php echo $form->error($model,'sex'); ?>
            </div>
	</div>

	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'city_id'); ?>
            </div>
            <div class="rightCol">
                <?php
                    $listCity = CHtml::listData(City::model()->findAll(array('order' => 'city_name')), 'city_id', 'city_name');
                    echo $form->dropDownList($model,'city_id', $listCity,array('style'=>'width:400px;height:40px;border-radius:5px;font-size:15px;padding:4px;background-color:#FFFFFF'));
                ?>
		<?php echo $form->error($model,'city_id'); ?>
            </div>
	</div>
        <?php if($model->isNewRecord){?>
	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'password'); ?>
            </div>
            <div class="rightCol">
		<?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>20,'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'password'); ?>
            </div>
	</div>
        <?php } ?>
	<div class="row">
            <div class="leftCol">
		<?php echo $form->labelEx($model,'isActive'); ?>
            </div>
            <div class="rightCol">
		<?php 
                    echo $form->checkBox($model,'isActive',array("id"=>"isActive"));
                ?>
		<?php echo $form->error($model,'isActive'); ?>
            </div>
	</div>

	<div class="row buttons">
            <?php echo CHtml::submitButton('Cancel', array('submit'=>'admin','class'=>'right')); ?>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'right')); ?>
        </div>

<?php $this->endWidget(); ?>
<?php 
    if(Yii::app()->user->hasFlash('createSuccess')){
        echo "<script>$(document).ready(function(){ createMaskWithMessage('".Yii::app()->user->getFlash('createSuccess')."')});</script>";
    }  
?>
</div><!-- form -->
<script>
    setMainMenuTabActive('bimpUser');
</script>