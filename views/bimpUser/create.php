<?php
/* @var $this BimpUserController */
/* @var $model BimpUser */
/* This will invoke user add form*/
?>

<br/>
<section>
    <h4 class="page-header-heading">&nbsp;&nbsp;Create New User</h4>
    <p class="add_player" style="float:right;  padding-left: 12px; margin-top: 0px;">
    <?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/images/homeList.jpeg" title="Manage Users">','admin',array('class'=>'floatRight')); ?></p>
    
</section>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>