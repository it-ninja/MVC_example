<?php
/* @var $this BimpUserController */
/* @var $model BimpUser */
/* This is to invoke edit user information form */
?>
<br/>
<section>
    <h4 class="page-header-heading">&nbsp;&nbsp;Update User Details</h4> 
    <p class="add_player" style="float:right;  padding-left: 12px; margin-top: 0px;">
    <?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/images/homeList.jpeg" title="Manage Users">','admin',array('class'=>'floatRight')); ?></p>
    
</section>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>