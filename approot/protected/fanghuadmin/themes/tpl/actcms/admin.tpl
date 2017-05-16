<?php
/* @var $this ActcmsController */
/* @var $model ArticleModel */

$this->breadcrumbs=array(
	'Article Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ArticleModel', 'url'=>array('index')),
	array('label'=>'Create ArticleModel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#article-model-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Article Models</h1>

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
	'id'=>'article-model-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'type',
		'content',
		'visit_url',
		'abstract',
		/*
		'status',
		'remark',
		'view_count',
		'share_count',
		'favor_count',
		'comment_count',
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
