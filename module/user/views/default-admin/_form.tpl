{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}

<div class="page-form">

    {$form = ActiveForm::begin()}

    <div class="panel panel-default">
        <div class="panel-heading">
            Główne
            {HTMLDecorator::langSwitcher()}
        </div>


        <div class="panel-body">

            <div class="form-group field-user-name{if $user->hasErrors('name')} has-error{/if}">
                <label class="control-label" for="user-name">`user.name`</label>
                {Html::input('text', 'name', $user->name, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
                <div class="help-block"></div>
            </div>

            <div class="field-user-email{if $user->hasErrors('email')} has-error{/if}">
                <label class="control-label" for="user-email">`user.email`</label>
                {Html::input('text', 'email', $user->email, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}

                <div class="help-block"></div>
            </div>

            <div class="field-user-password{if $user->hasErrors('password')} has-error{/if}">
                <label class="control-label" for="user-password">`user.password`</label>
                {Html::input('text', 'password', $user->password, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}

                <div class="help-block"></div>
            </div>
            <div class="form-group">
                {Html::submitButton('`page.save`', ['class' => 'btn btn-success'])}
            </div>
        </div>
    </div>

    {ActiveForm::end()|void}

</div>
