{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}

<div class="page-form">

    {$form = ActiveForm::begin(['action' => '/admin/module/doinstall'])}

    <div class="panel panel-default">
        <div class="panel-heading">
            Główne
            {HTMLDecorator::langSwitcher()}
        </div>

        <div class="panel-body">
            <label>
                `module.module_select`
            </label>
                <select name="Module[name]" class="form-control">
                {foreach $moduleFinder->getToInstall() as $name => $mod}
                    <option value="{$name}"{if $module->name == $name} selected="selected"{/if}>{$name}</option>
                {/foreach}
            </select>

            <div class="form-group field-module-long_name">
                <label class="control-label" for="module-long_nale">`module.long_name`</label>
                {HTMLDecorator::multiLangInput($module, 'text', 'long_name', ['class' => 'form-control', 'id' => 'module-long_name', 'max-length' => '100'])}
                <div class="help-block"></div>
            </div>

            <div class="checkbox">
                <label>
                    {HTMLDecorator::checkbox('Module[is_visible]', $module->is_active, ['id' => 'module-is_visible'])} `module.is_visible`
                </label>
            </div>

            <div class="checkbox">
                <label>
                    {HTMLDecorator::checkbox('Module[technical_user_only]', $module->technical_user_only, ['id' => 'module-technical_user_only'])} `module.technical_user_only`
                </label>
            </div>

            <div class="checkbox">
                <label>
                    {HTMLDecorator::checkbox('Module[admin_access]', $module->admin_access, ['id' => 'module-admin_access'])} `module.admin_access`
                </label>
            </div>

            <div class="form-group">
                {Html::submitButton('`module.install`', ['class' => 'btn btn-success'])}
            </div>
        </div>
    </div>

    {ActiveForm::end()|void}

</div>
