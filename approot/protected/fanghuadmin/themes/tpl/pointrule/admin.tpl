<?php
/* @var $this PointRuleController */
/* @var $model PointRule */

$this->breadcrumbs=array(
	'Point Rules'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PointRule', 'url'=>array('index')),
	array('label'=>'Create PointRule', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#point-rule-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Point Rules</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'point-rule-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rule_id',
		'rule_name',
		'rule_action',
		'rule_point',
		'status',
		'create_time',
		/*
		'last_modified',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
