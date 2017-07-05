<?php
/* @var $this TaskBuildingController */
/* @var $model TaskBuilding */

$this->breadcrumbs=array(
	'Task Buildings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TaskBuilding', 'url'=>array('index')),
	array('label'=>'Create TaskBuilding', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#task-building-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Task Buildings</h1>

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
	'id'=>'task-building-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'task_id',
		'task_title',
		'task_url',
		'task_img',
		'building_name',
		'building_address',
		/*
		'building_open_time',
		'building_price',
		'building_detail',
		'brokerage_max',
		'dividend_ratio',
		'point_amount',
		'status',
		'flag',
		'create_time',
		'last_modified',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
