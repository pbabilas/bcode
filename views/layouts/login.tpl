{use class="yii\helpers\Html"}
{use class="yii\bootstrap\Nav"}
{use class="yii\bootstrap\NavBar"}
{use class="yii\widgets\Breadcrumbs"}
{use class="app\assets\AdminAsset"}
{use class="app\common\widgets\Menu"}


{AdminAsset::register($this)|void}

{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{Html::encode($this->title)}</title>
    <base href="http://bcode.lh">
    {$this->head()}
    {Html::csrfMetaTags()}
</head>
<body class="hold-transition login-page">
    {$this->beginBody()}

        {*if Yii::$app->session->hasFlash('alert')}
            {foreach Yii::$app->session->getFlash('alert') as $message}
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-ban"></i> {$message|replace:'\n':'<br />'}
                </div>
            {/foreach}
        {/if}
        {if Yii::$app->session->hasFlash('info')}
            {foreach Yii::$app->session->getFlash('info') as $message}
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-info"></i> {$message|replace:'\n':'<br />'}
                </div>
            {/foreach}
        {/if*}

    <div class="login-box">

        <div class="login-logo">
            <a href="/"><img src="img/logo.png" /></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">`user.login_info`</p>

                {$content}

            <a href="#">I forgot my password</a><br>

        </div>
        <!-- /.login-box-body -->
    </div>
    {$this->endBody()}
</div>
</body>
</html>
{$this->endPage()}
