{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}

<!-- /.box-header -->
<!-- form start -->
{$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])}
<div class="box-body">
    <div class="form-group">
        <label for="page-title">`user.name`</label>
        {Html::input('text', 'User[name]', $user->name, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
    </div>
    <div class="form-group">
        <label for="page-body">`user.email`</label>
        {Html::input('text', 'User[email]', $user->email, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
    </div>
    <div class="form-group">
        <label for="page-body">`user.password`</label>
        {Html::input('password', 'User[password]', $user->password, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
    </div>
    <div class="checkbox">
        <label for="page-body">
            {$roles = Yii::$app->getAuthManager()->getRolesByUser($user->id)}
            {Html::checkbox('technical_user', array_key_exists('accessModule', $roles), ['id' => 'technical-user'])}
            `user.technical`
        </label>
    </div>

    <div class="form-group">
        <div class="pull-left">
            <img src="{$user->getPictureUrl($user->picture_filename, '100x100')}" class="img-circle" />
        </div>
        <div class="pull-left col-lg-offset-1">
            <label for="exampleInputFile">`user.picture`</label>
            <input type="file" id="picture" name="userPicture">
            <p class="help-block">
                <label for="exampleInputFile">
                    {Html::checkbox('userPictureDelete', false, ['id' => 'user-picture-delete'])}
                    `user.picture-delete`
                </label>
            </p>
        </div>

    </div>
</div>
<!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-flat btn-primary">`user.save`</button>
</div>
{ActiveForm::end()|void}
