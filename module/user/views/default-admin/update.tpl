{use class="yii\helpers\Html"}


<div class="user-update">

    <h1>{Html::encode($this->title)}</h1>

    {$this->render('_form.tpl', [
        'user' => $user
    ])}

</div>
