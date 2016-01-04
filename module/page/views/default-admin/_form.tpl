{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm"}
{use class="app\decorator\HTMLDecorator"}




<!-- /.box-header -->
<!-- form start -->
{$form = ActiveForm::begin()}
    <div class="box-body">
        <div class="form-group">
            <label for="page-title">`page.title`</label>
            {HTMLDecorator::multiLangInput($page, 'text', 'title', ['class' => 'form-control', 'id' => 'page-title', 'max-length' => '100'])}
        </div>
        <div class="form-group">
            <label for="page-body">`page.body`</label>
            {HTMLDecorator::multiLangTextarea($page, 'body', ['class' => 'form-control wysiwyg', 'id' => 'page-body', 'max-length' => '100', 'rows' => '15'])}
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">`page.save`</button>
    </div>
{ActiveForm::end()|void}



