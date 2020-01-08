<div class="form" class="rinchans">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'Categories-form',
		'enableClientValidation' => false,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row form-group">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('size' => 80, 'maxlength' => 128)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
