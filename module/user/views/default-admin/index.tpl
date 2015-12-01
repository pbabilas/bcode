{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}



<div class="user-index">

    <h1>{Html::encode($this->title)}</h1>

    <p>
        {Html::a('`user.create_user`', ['create'], ['class' => 'btn btn-success'])}
    </p>

    {GridView::widget([
        'tableOptions' => [
            'class' => 'table table-hover hidden-phone'
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => '\yii\grid\SerialColumn'],
            'name',
            'email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]
    )}

</div>
