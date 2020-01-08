<div class="col-md-4">
	<div class="post">
		<a class="post-img" href="<?php echo $data->url ?>">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/<?php echo $data->image ?>" alt="">
		</a>
			<div class="post-body">
				<div class="post-meta">
				<a class="post-category cat-1">
					<?php echo $data->tags ?>
				</a>
					<span class="post-date">
						<?php echo date('F j, Y', $data->update_time); ?>
					</span>
				</div>
				<h3 class="post-title mg-b-20"><a href="<?php echo $data->url ?>">
					<?php echo $data->title ?>
				</a></h3>
				<span>Tags : <i><?php  echo implode(', ', $data->tagLinks); ?></i></span>
				<div class="follow">
						<button class="btn followButton button" rel="6" data-id="<?php echo $data->id ?>">Follow</button>
					</div>
			</div>
	</div>
</div>