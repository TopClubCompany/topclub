<?php
/* @var $this ModelController */
/* @var $title string */
/* @var $model object */
/* @var $form TbActiveForm */

$this->pageTitle = $title;

$attributes = array();
foreach ($model->getAttributes() as $attribute => $label) {
	$label = $model->getAttributeLabel($attribute);
	if (isset($model->tableSchema->columns[$attribute]) && $model->tableSchema->columns[$attribute]->isPrimaryKey === true) {
		continue;
	}
	$attributes[] = $attribute;
}
$attributes = array_filter(array_unique(array_map('trim', $attributes)));
?>
<div class="row-fluid">
	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => get_class($model) . '-id-form',
		'type' => 'horizontal',
		'inlineErrors' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
	echo $form->errorSummary($model);
	if (method_exists($model, 'tabedForm')) {
		$this->widget($this->module->name . '.extensions.yiicm.ETabbedForm', array(
			$model->tabedForm()
		));
	} else {
		foreach ($attributes as $attribute) {
			$this->module->createWidget($form, $model, $attribute);
		}
	}
	?>
	<div class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="navbar-inner">
			<div class="container-fluid pull-right">
				<?php
				$buttons = array(
					array(
						'buttonType' => 'submit',
						'type' => 'primary',
						'label' => Yii::t('YcmModule.ycm', 'Save'),
						'htmlOptions' => array('name' => '_save', 'style' => 'margin-left:10px;')
					),
					array(
						'buttonType' => 'submit',
						'label' => Yii::t('YcmModule.ycm', 'Save and add another'),
						'htmlOptions' => array('name' => '_addanother', 'style' => 'margin-left:10px;')
					),
					array(
						'buttonType' => 'submit',
						'label' => Yii::t('YcmModule.ycm', 'Save and continue editing'),
						'htmlOptions' => array('name' => '_continue', 'style' => 'margin-left:10px;')
					),
				);
				if (!$model->isNewRecord) {
					array_push($buttons, array(
						'buttonType' => 'link',
						'type' => 'danger',
						'url' => '#',
						'label' => Yii::t('YcmModule.ycm', 'Delete'),
						'htmlOptions' => array(
							'submit' => array(
								'model/delete',
								'name' => get_class($model),
								'pk' => $model->primaryKey,
							),
							'style' => 'margin-left:10px;',
							'confirm' => Yii::t('YcmModule.ycm', 'Are you sure you want to delete this item?'),
						)
					));
				}
				foreach ($buttons as $button) {
					$this->widget('bootstrap.widgets.TbButton', $button);
				}
				?>
			</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
