{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}
{use class="app\helper\UrlHelper"}
{use class="yii\widgets\LinkPager"}

<div class="box">
    <div class="box-header">
        <h3 class="box-title">{Html::a('`user.groups_managment`', 'admin/user/group/new', ['class' => 'btn btn-flat btn-primary'])}</h3>

        {*<div class="box-tools">*}
            {*<form method="post">*}
                {*<div class="input-group input-group-sm" style="width:150px;">*}
                    {*<input type="text" name="Page[title__pl]" class="form-control pull-right" placeholder="Search">*}

                    {*<div class="input-group-btn">*}
                        {*<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>*}
                    {*</div>*}
                {*</div>*}
            {*</form>*}
        {*</div>*}
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>`group.name`</th>
                <th>`group.description`</th>
                <th>`group.created_at`</<th>
                <th>`group.options`</th>
            </tr>
            {foreach $groups as $i => $group}
                <tr>
                    <td>
                        {$group->name}
                    </td>
                    <td>
                        {$group->description}
                    </td>
                    <td>
                        {$group->createdAt|date_format:'Y-m-d G:i:s'}
                    </td>
                    <td>
                        <a href="/admin/user/group/edit?name={$group->name}" class="glyphicon glyphicon-edit" aria-hidden="true" title="`group.edit`"></a>
                        <a href="/admin/user/group/delete?name={$group->name}" class="glyphicon glyphicon-trash" aria-hidden="true" title="`group.delete`"></a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        {*<div class="col-md-7 col-md-offset-5">*}
            {*{LinkPager::widget([*}
            {*'pagination' => $search->getPaginator()*}
            {*])}*}
        {*</div>*}
    </div>

    <!-- /.box-body -->
</div>
<!-- /.box -->
