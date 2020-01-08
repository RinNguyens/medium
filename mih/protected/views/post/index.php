<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewRin',
	'template'=>"{items}\n{pager}",
)); ?>

