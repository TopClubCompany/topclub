<?php
/* @var $this ModelController */
/* @var $title string */
/* @var $model object */
/* @var $data array */

$this->setPageTitle($title);
?>
<?php $this->widget('bootstrap.widgets.TbGridView', $data); ?>
<div class="navbar navbar-inverse navbar-fixed-bottom">
	<div class="navbar-inner">
		<div class="container-fluid pull-right">
			<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'type' => 'primary',
				'label' => Yii::t('YcmModule.ycm', 'Create {name}', array('{name}' => $this->module->getSingularName($model))
				),
				'url' => $this->createUrl('model/create', array('name' => get_class($model))),
			));
			?>
		</div>
	</div>
</div>