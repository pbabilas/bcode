{use class="app\assets\AdminAsset"}

{$this->registerJsFile('/js/module/dashboard.js', ['depends' => [AdminAsset::className()]])}

{include file="@app/module/dashboard/views/widget/admin/widgets.tpl"}

<!-- Modal -->
<div class="modal fade" id="wigetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">`dashboard.add_widget`</h4>
            </div>
            <div class="modal-body">
                {foreach $finder->getAll() as $i => $widget}
                    <a href="/admin/dashboard/widget/add/?offset={$i}" class="btn btn-app widget-add">
                        <i class="fa fa-{$widget->getIcon()}"></i> {$widget->getTitle()}
                    </a>
                {/foreach}
            </div>
        </div>
    </div>
</div>
