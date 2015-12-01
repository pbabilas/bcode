
{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="yii\widgets\Breadcrumbs"}



<div class="user login">
    <div class="inner">
        {$form = ActiveForm::begin()}
        <fieldset>
            {$form->field($user, 'name', ['template' => '{input}'])->textInput(['placeholder' => '`app.user`'])}
        </fieldset>
        <fieldset>
            {$form->field($user, 'password', ['template' => '{input}'])->passwordInput(['placeholder' => '`app.password`'])}
        </fieldset>

        <fieldset>
            <div class="form-group field-user-name required has-error">
                {Html::submitButton('`app.login`', ['class' => 'btn btn-primary'])}
            </div>

        </fieldset>
        {ActiveForm::end()|void}
    </div>
</div>