<div class="container">
	<div class="col-md-4">
		<ul>
			<li><?php echo CHtml::link('Create New Post', array('post/create')); ?></li>
			<li><?php echo CHtml::link('Manage Posts', array('post/admin')); ?></li>
			<li><?php echo CHtml::link('Approve Comments', array('comment/index')) . ' (' . Comment::model()->pendingCommentCount . ')'; ?></li>
			<li><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
		</ul>
	</div>
	<div class="col-md-4">
		<ul>
		<li><?php echo CHtml::link('Home Category', array('categories/index')); ?></li>

			<li><?php echo CHtml::link('Create New Category', array('categories/create')); ?></li>
			<li><?php echo CHtml::link('Manage Category', array('categories/admin')); ?></li>
			<li><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
		</ul>
	</div>
</div>