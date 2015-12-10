{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}


<div class="page-index">

    <h1>{Html::encode($this->title)}</h1>

    <p>
        {Html::a('`page.create_page`', ['create'], ['class' => 'btn btn-success'])}
    </p>

	{GridView::widget([
		'tableOptions' => [
			'class' => 'table table-hover hidden-phone'
		],
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => '\yii\grid\SerialColumn'],
			'title__pl',
			[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
		]
	]
    )}

</div>
