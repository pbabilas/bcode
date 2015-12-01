{use class="yii\helpers\Html"}


<div class="page-update">

    <h1>{Html::encode($this->title)}</h1>

    {$this->render('_form.tpl', [
        'page' => $page
    ])}

</div>
