{use class="yii\helpers\Html"}

<div class="col-lg-4">
    <div class="panel panel-info">
        <div class="panel-heading">
            `page.page_edit`
        </div>

        <p class="panel-body">
            `page.edit_info`.<br />
            <br />
        </p>
    </div>
</div>

<div class="page-create col-lg-8">

    {$this->render('_form.tpl', [
        'page' => $page
    ]) }

</div>
