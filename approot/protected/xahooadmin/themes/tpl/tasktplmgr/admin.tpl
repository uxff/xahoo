<?php
/* @var $this TaskTplMgrController */
/* @var $model TaskTplModel */

$this->breadcrumbs=array(
	'Task Tpl Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TaskTplModel', 'url'=>array('index')),
	array('label'=>'Create TaskTplModel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#task-tpl-model-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Task Tpl Models</h1>

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
	'id'=>'task-tpl-model-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'task_id',
		'task_name',
		'task_type',
		'task_desc',
		'task_url',
		'surface_url',
		/*
		'act_type',
		'reward_points',
		'rule_id',
		'step_need_count',
		'weight',
		'status',
		'flag',
		'create_time',
		'last_modified',
		'admin_id',
		'admin_name',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
