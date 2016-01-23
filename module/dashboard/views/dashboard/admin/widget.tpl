{$widgetObject = $widget->getObject()}

{$offset = $widgetObject->getOffset()}
<div class="col-md-{$widgetObject->getWidth()}{if $offset} col-md-offset-{$offset}{/if}">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{$widgetObject->getTitle()}</h3>

            <div class="box-tools pull-right">
                <div class="pull-right box-tools">
                    <a href="admin/dashboard/widget/delete?id={$widget->id}" class="btn btn-success btn-sm widget-delete" ><i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
        {$content = $widgetObject->getContentsTemplate()}
        <!-- /.box-header -->
        {include file=$content}
        <!-- ./box-body -->
    </div>
    <!-- /.box -->
</div>