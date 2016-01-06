{use class="yii\helpers\Html"}
{use class="app\decorator\HTMLDecorator"}

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">`user.create_user`</h3>
            </div>

            {$this->render('_form.tpl', [
                'user' => $user
            ]) }
        </div>
    </div>

</div>