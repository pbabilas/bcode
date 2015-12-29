{use class="yii\helpers\Html"}
{use class="yii\bootstrap\Nav"}
{use class="yii\bootstrap\NavBar"}
{use class="yii\widgets\Breadcrumbs"}
{use class="app\assets\AdminAsset"}


{AdminAsset::register($this)|void}

{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{Html::encode($this->title)}</title>
    {$this->head()}
    {Html::csrfMetaTags()}
</head>
<body>
<div class="wrap">
    {$this->beginBody()}

    {NavBar::begin([ 'brandLabel' => '<strong>{<span style="color: red">b</span>-<span style="color: black">code</span>}</strong>',
        'brandUrl' => '/admin',
        'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top'
            ]
    ])|void}

    <p class="navbar-text navbar-right">
        `user.logged_as` {\Yii::$app->user->identity->name}, <a href="/user/logout" class="navbar-link">`user.logout`</a>!
    </p>
    {NavBar::end()|void}

    <div class="container">
        {if isset($this->params['breadcrumbs'])}
            {Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
                'homeLink' => false
            ])}
        {/if}


        {if Yii::$app->session->hasFlash('alert')}
            <div class="alert alert-danger">
                {Yii::$app->session->getFlash('alert')|replace:'\n':'<br />'}
            </div>
        {/if}
        {if Yii::$app->session->hasFlash('info')}
            <div class="alert alert-info">
                {Yii::$app->session->getFlash('info')|replace:'\n':'<br />'}
            </div>
        {/if}
        {$content}
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; B-code.pl <?= date('Y') ?></p>
            <p class="pull-right">Wykonanie: <a href="#">B-Code</a></a></p>
        </div>
    </footer>

    {$this->endBody()}
</div>
</body>
</html>
{$this->endPage()}
