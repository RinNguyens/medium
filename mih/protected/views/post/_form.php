<div class="form" class="rinchans">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'imageGallery-form',
		'enableClientValidation' => false,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
		'htmlOptions' => array('enctype' => 'multipart/form-data'), // This is required for file upload
	)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row form-group">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('size' => 80, 'maxlength' => 128)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'content'); ?>
		<?php echo CHtml::activeTextArea($model, 'content', array('rows' => 10, 'cols' => 70)); ?>
		<?php echo $form->error($model, 'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model' => $model,
			'attribute' => 'tags',
			'url' => array('suggestTags'),
			'multiple' => true,
			'htmlOptions' => array('size' => 50),
		)); ?>
		<p class="hint">Please separate different tags with commas.</p>
		<?php echo $form->error($model, 'tags'); ?>
	</div>
	
	<div class="row">
		<span class="span-4">Upload images:</span>
		<?php echo $form->fileField($model, 'image', array('id' => 'file')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
$('#imageGallery-form').live("submit", function(event){
    var success = true;
    $form = $(this);
     if(/.*\.(gif)|(jpeg)|(jpg)|(doc)$/.test($("#file").val().toLowerCase())){
         $("#fname").removeClass("error");
    }else{
        $("#error_ul").append("<li>Please Choose Gif or Jpg Images Only.!!</li>");
        $(".errorSummary").show();
        $("#fname").addClass("error");
        success = false;
    }

}); 
</script>