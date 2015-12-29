{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}



<div class="user-index">

    <h1>{Html::encode($this->title)}</h1>

    <p>
        {Html::a('`module.install_module`', ['install'], ['class' => 'btn btn-success'])}
    </p>

    <table class="table table-hover hidden-phone">
        <thead>
            <tr>
                <th>#</th>
                <th>`module.name`</th>
                <th>`module.is_active`</th>
                <th>`module.technical_user`</th>
                <th>`module.admin_access`</th>
                <th>`module.version`</th>
            </tr>
        </thead>
        <tbody>
            {foreach $modules as $i => $module}
                <tr>
                    <td>{$module->id}</td>
                    <td>{$module->get('long_name')}</td>
                    <td>`module.{$module->is_active|replace:1:'yes'|replace:0:'no'}`</td>
                    <td>`module.{$module->technical_user_only|replace:1:'yes'|replace:0:'no'}`</td>
                    <td>`module.{$module->admin_access|replace:1:'yes'|replace:0:'no'}`</td>
                    <td>{$module->version}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


</div>
