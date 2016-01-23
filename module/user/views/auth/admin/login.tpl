
{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="yii\widgets\Breadcrumbs"}



{*<div class="user login">*}
    {*<div class="inner">*}
        {*{$form = ActiveForm::begin()}*}
        {*<fieldset>*}
            {*{$form->field($user, 'name', ['template' => '{input}'])->textInput(['placeholder' => '`app.user`'])}*}
        {*</fieldset>*}
        {*<fieldset>*}
            {*{$form->field($user, 'password', ['template' => '{input}'])->passwordInput(['placeholder' => '`app.password`'])}*}
        {*</fieldset>*}

        {*<fieldset>*}
            {*<div class="form-group field-user-name required has-error">*}
                {*{Html::submitButton('`app.login`', ['class' => 'btn btn-primary'])}*}
            {*</div>*}

        {*</fieldset>*}
        {*{ActiveForm::end()|void}*}
    {*</div>*}
{*</div>*}






        {$form = ActiveForm::begin()}
            <div class="form-group has-feedback">
                {Html::input('text', 'User[name]', $user->name, ['placeholder' => '`user.user`', 'class' => 'form-control'])}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {Html::input('password', 'User[password]', null, ['placeholder' => '`user.password`', 'class' => 'form-control'])}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">

                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">`user.action_login`</button>
                </div>
                <!-- /.col -->
            </div>
        {ActiveForm::end()|void}
        <!-- /.social-auth-links -->
