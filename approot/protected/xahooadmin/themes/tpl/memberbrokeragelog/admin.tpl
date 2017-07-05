<?php
/* @var $this MemberBrokerageLogController */
/* @var $model MemberBrokerageLog */

$this->breadcrumbs=array(
	'Member Brokerage Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MemberBrokerageLog', 'url'=>array('index')),
	array('label'=>'Create MemberBrokerageLog', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#member-brokerage-log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Member Brokerage Logs</h1>

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
	'id'=>'member-brokerage-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'brokerage_id',
		'member_id',
		'brokerage_before',
		'brokerage_after',
		'brokerage_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
