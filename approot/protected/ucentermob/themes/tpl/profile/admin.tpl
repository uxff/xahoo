<?php
/* @var $this ProfileController */
/* @var $model UcMember */

$this->breadcrumbs=array(
'Uc Members'=>array('index'),
'Manage',
);

$this->menu=array(
array('label'=>'List UcMember', 'url'=>array('index')),
array('label'=>'Create UcMember', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$('#uc-member-grid').yiiGridView('update', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Uc Members</h1>

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
'id'=>'uc-member-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
'member_id',
'member_fullname',
'member_email',
'member_mobile',
'member_gender',
'member_age',
/*
'member_birthday',
'member_address',
'member_avatar',
'member_nickname',
'member_password',
'is_newsletter',
'is_email_actived',
'is_mobile_actived',
'is_actived',
'status',
'create_time',
'last_modified',
*/
array(
'class'=>'CButtonColumn',
),
),
)); ?>
