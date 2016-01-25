{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}


    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{Html::a('`user.create_user`', 'admin/user/create', ['class' => 'btn btn-flat btn-primary'])}</h3>

            <div class="box-tools">
                <div class="input-group input-group-sm" style="width:150px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody><tr>
                    <th>`user.login`</th>
                    <th>`user.email`</th>
                    <th></th>
                </tr>
                {foreach $dataProvider->getModels() as $i => $user}
                    <tr>
                        <td>
                            <img src="{$user->getPictureUrl($user->picture_filename, '32x32')}" class="img-circle" />
                            {$user->name}
                        </td>
                        <td>{$user->email}</td>
                        <td>
                            <a href="/admin/user/edit?id={$user->id}" class="glyphicon glyphicon-edit" aria-hidden="true" title="`page.edit`"></a>
                            <a href="/admin/user/reset?id={$user->id}" class="glyphicon glyphicon-refresh" aria-hidden="true" title="`page.reset_password`"></a>
                            <a href="/admin/user/delete?id={$user->id}" class="glyphicon glyphicon-trash" aria-hidden="true" title="`page.delete_page`"></a>
                        </td>
                    </tr>
                {/foreach}
                </tbody></table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
