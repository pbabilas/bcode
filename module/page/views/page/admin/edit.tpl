{use class="yii\helpers\Html"}
{use class="app\decorator\HTMLDecorator"}


<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">`page.create_page`</h3>
                {HTMLDecorator::langSwitcher()}
            </div>

            {$this->render('_form.tpl', [
                'page' => $page
            ])}
        </div>
    </div>
</div>
