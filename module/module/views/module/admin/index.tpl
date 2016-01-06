{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}



<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{Html::a('`module.install_module`', ['install'], ['class' => 'btn btn-primary'])}</h3>

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
                <thead>
                    <tr>
                        <th>#</th>
                        <th>`module.name`</th>
                        <th>`module.is_active`</th>
                        <th>`module.technical_user`</th>
                        <th>`module.admin_access`</th>
                        <th>`module.version`</th>
                        <th>`module.options`</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $modules as $i => $module}
                        {$i++|void}
                        <tr>
                            <td>{$i}</td>
                            <td>{$module->long_name}</td>
                            <td>`module.{$module->is_active|replace:1:'yes'|replace:0:'no'}`</td>
                            <td>`module.{$module->technical_user_only|replace:1:'yes'|replace:0:'no'}`</td>
                            <td>`module.{$module->admin_access|replace:1:'yes'|replace:0:'no'}`</td>
                            <td>{$module->version}</td>
                            <td>
                                <a href="/admin/module/uninstall?id={$module->id}" class="glyphicon glyphicon-trash" aria-hidden="true" title="`module.delete_module`"></a>
                                {if $module->isActual() == false}
                                    <a href="admin/module/update?id={$module->id}" class="glyphicon glyphicon-send" aria-hidden="true" title="`module.update_module`"></a>
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>