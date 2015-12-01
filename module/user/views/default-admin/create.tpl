{use class="yii\helpers\Html"}

<div class="col-lg-4">
    <div class="panel panel-info">
        <div class="panel-heading">
            `user.user_create`
        </div>

        <p class="panel-body">
            `user.user_info`.<br />
            <br />
        </p>
    </div>
</div>

<div class="page-create col-lg-8">

    {$this->render('_form.tpl', [
        'user' => $user
    ]) }

</div>
