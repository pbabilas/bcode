{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}

<!-- /.box-header -->
<!-- form start -->
{$form = ActiveForm::begin()}
<div class="box-body">
    <div class="form-group">
        <label for="group-name">`group.name`</label>
        <input id="group-name" type="text" name="Group[name]" class="form-control" value="{$group->name}" />
    </div>
    <div class="form-group">
        <label for="group-description">`group.description`</label>
        <textarea id="group-description" name="Group[description]" class="form-control">{$group->description}</textarea>
    </div>
</div>
<div class="box-body">
    <h3>`group.module_permissions`</h3>
    {foreach $finder->getAllSystemModules() as $moduleName => $value}
        {$permissionName = sprintf('access%s', ucfirst($moduleName))}
        <div class="form-group">
            <label for="group-name">
                <input type="checkbox" id="group-name" name="Permission[]" value="{$permissionName}" {if array_key_exists($permissionName, $group->getPermissions())} checked="checked"{/if} />
                `group.{$permissionName}`
            </label>
        </div>
    {/foreach}

</div>
<!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">`page.save`</button>
</div>
{ActiveForm::end()|void}



