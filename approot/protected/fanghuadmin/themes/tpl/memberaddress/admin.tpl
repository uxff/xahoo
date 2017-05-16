<?php
/* @var $this MemberAddressController */
/* @var $model MemberAddress */

$this->breadcrumbs=array(
	'Member Addresses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MemberAddress', 'url'=>array('index')),
	array('label'=>'Create MemberAddress', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#member-address-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Member Addresses</h1>

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
	'id'=>'member-address-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'province_id',
		'city_id',
		'county_id',
		'consignee_name',
		'consignee_mobile',
		/*
		'address',
		'member_id',
		'create_time',
		'update_time',
		'is_default',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
