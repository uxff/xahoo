<?php
/* @var $this HotArticleController */
/* @var $model HotArticleModel */

$this->breadcrumbs=array(
	'Hot Article Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List HotArticleModel', 'url'=>array('index')),
	array('label'=>'Create HotArticleModel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#hot-article-model-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Hot Article Models</h1>

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
	'id'=>'hot-article-model-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'tips',
		'act_type',
		'status',
		'url',
		/*
		'is_local_url',
		'weight',
		'surface_url',
		'create_time',
		'last_modified',
		'author_id',
		'author_name',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
