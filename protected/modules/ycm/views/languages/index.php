<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => Languages::model()->search()
)); ?>

<?php echo $this->module->getButtons(); ?>