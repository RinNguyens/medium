<?php $this->beginContent('/layouts/main'); ?>

<div class="section">
	<div class="container">
		<?php echo $content; ?>
	</div>
</div>
<div class="container">
	<div id="sidebar">
		<?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>

		<?php $this->widget('TagCloud', array(
			'maxTags'=>Yii::app()->params['tagCloudCount'],
		)); ?>

		<?php $this->widget('RecentComments', array(
			'maxComments'=>Yii::app()->params['recentCommentCount'],
		)); ?>
	</div>
</div>
<?php $this->endContent(); ?>