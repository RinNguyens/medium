<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- blueprint CSS framework -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div class="container" id="page">



		<div class="main">
			<?php $this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array('label' => 'Home', 'url' => array('post/index')),
					array('label' => 'About', 'url' => array('site/page', 'view' => 'about')),
					array('label' => 'Contact', 'url' => array('site/contact')),
					array('label' => 'Login', 'url' => array('site/login'), 'visible' => Yii::app()->user->isGuest),
					array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('site/logout'), 'visible' => !Yii::app()->user->isGuest)
				),
				'htmlOptions' => array('class' => 'nav navbar-nav'),
			)); ?>
		</div><!-- mainmenu -->
		<div style='float: right;direction: rtl; color: #000; margin: 5px 0 0 5px; font-size: 13px'>
			<?php echo CHtml::form(Yii::app()->createUrl('post/search'), 'get') ?>
			<?php echo CHtml::textField('search_key', '') ?>
			<?php echo CHtml::submitButton(); ?>
			<?php echo CHtml::endForm() ?>
		</div>
		<div class="clearfix"></div>
		<div class="nav-top">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">

				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<?php
						
						$pRows = Categories::model()->with('Post')->findAll(

							"Post.categories = :id",
						
							array(
						
								':id' => 6
						
							)
						
						);
						
						echo "<pre>";
						print_r($pRows);
						echo "</pre>";
						die;
						
						
						?>
					</ul>
				</div>
		</div>
	</div><!-- page -->
	<?php echo $content; ?>


	<div class="container">
		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by Make It Happen.<br />
			Happy Coding ^^!.<br />
			<?php echo Yii::powered(); ?>
		</div><!-- footer -->
	</div>

</body>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>



</html>