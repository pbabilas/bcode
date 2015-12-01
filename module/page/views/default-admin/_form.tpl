{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}

<div class="page-form">

    {$form = ActiveForm::begin()}

    <div class="panel panel-default">
        <div class="panel-heading">
            Główne
            {HTMLDecorator::langSwitcher()}
        </div>


        <div class="panel-body">

            <div class="form-group field-page-title{if $page->hasErrors('title__pl')} has-error{/if}">
                <label class="control-label" for="page-title">`page.title`</label>
                {HTMLDecorator::multiLangInput($page, 'text', 'title', ['class' => 'form-control', 'id' => 'page-title', 'max-length' => '100'])}
                <div class="help-block"></div>
            </div>


            <div class="field-page-body{if $page->hasErrors('body__pl')} has-error{/if}">
                <label class="control-label" for="page-body">`page.body`</label>
				{HTMLDecorator::multiLangTextarea($page, 'body', ['class' => 'form-control', 'id' => 'page-body', 'max-length' => '100', 'rows' => '15'])}

                <div class="help-block"></div>
            </div>
            <div class="form-group">
                {Html::submitButton('`page.save`', ['class' => 'btn btn-success'])}
            </div>
        </div>
    </div>

    {ActiveForm::end()|void}

</div>
