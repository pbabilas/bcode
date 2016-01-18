{use class="yii\helpers\Html"}
{use class="app\decorator\HTMLDecorator"}

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">`group.new`</h3>
                {HTMLDecorator::langSwitcher()}
            </div>

            {include file="form.tpl"}
            {*{$this->render('_form.tpl', [*}
            {*'page' => $page*}
            {*]) }*}
        </div>
    </div>

</div>
