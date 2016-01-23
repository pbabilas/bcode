{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}
{use class="app\module\user\models\Group"}

<!-- /.box-header -->
<!-- form start -->
{$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])}
<div class="box-body">
    <div class="form-group">
        <label for="page-title">`user.name`</label>
        {Html::input('text', 'User[name]', $user->name, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
    </div>
    <div class="form-group">
        <label for="page-title">`user.first_name`</label>
        {Html::input('text', 'User[first_name]', $user->first_name, ['class' => 'form-control', 'id' => 'user-first_name', 'max-length' => '64'])}
    </div>
    <div class="form-group">
        <label for="page-title">`user.surname`</label>
        {Html::input('text', 'User[surname]', $user->surname, ['class' => 'form-control', 'id' => 'user-surname', 'max-length' => '64'])}
    </div>
    <div class="form-group">
        <label for="page-title">`user.phone_number`</label>
        {Html::input('number', 'User[phone_number]', $user->phone_number, ['class' => 'form-control', 'id' => 'user-phone_number' ])}
    </div>
    <div class="form-group">
        <label for="page-body">`user.email`</label>
        {Html::input('text', 'User[email]', $user->email, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
    </div>
    <div class="form-group">
        <label for="page-body">`user.password`</label>
        {Html::input('password', 'User[password]', $user->password, ['class' => 'form-control', 'id' => 'user-name', 'max-length' => '100'])}
    </div>
    <div class="form-group">
        <label for="user-role">`user.role`</label>
            {$roles = Group::findAll()}
            {$roleArray = Yii::$app->getAuthManager()->getRolesByUser($user->id)}
            {$role = key($roleArray)}
            <select id="user-role" name="Role" class="form-control">
                {foreach $roles as $r}
                    <option value="{$r->name}"{if $r->name == $role} selected="selected"{/if}>
                        {$r->name}{if $r->description != ''} ({$r->description}){/if}
                    </option>
                {/foreach}
            </select>

    </div>

    <div class="form-group">
        {if $user->picture_filename != ''}
            <div class="pull-left">
                <img src="{$user->getPictureUrl($user->picture_filename, '100x100')}" class="img-circle" />
            </div>
        {/if}
        <div class="pull-left{if $user->picture_filename != ''} col-lg-offset-1{/if}">
            <label for="exampleInputFile">`user.picture`</label>
            <input type="file" id="picture" name="userPicture">
            {if $user->picture_filename != ''}
                <p class="help-block">
                    <label for="exampleInputFile">
                        {Html::checkbox('userPictureDelete', false, ['id' => 'user-picture-delete'])}
                        `user.picture-delete`
                    </label>
                </p>
            {/if}
        </div>

    </div>
</div>

<!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-flat btn-primary">`user.save`</button>
</div>
{ActiveForm::end()|void}
