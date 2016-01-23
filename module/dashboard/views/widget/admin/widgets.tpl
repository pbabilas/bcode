<div class="row" id="widgetsDashboard">
    {foreach $widgets as $widget}
        {include file="@app/module/dashboard/views/dashboard/admin/widget.tpl"}
    {/foreach}
</div>