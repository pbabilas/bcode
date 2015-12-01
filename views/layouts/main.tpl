{use class="yii\helpers\Html"}
{use class="yii\widgets\Breadcrumbs"}
{use class="app\assets\AppAsset"}

{AppAsset::register($this)|void}

{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
<head>
    <meta charset="{Yii::$app->charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {Html::csrfMetaTags()}
    <title>{Html::encode($this->title)}</title>
    {$this->head()}
</head>
<body>
{$this->beginBody()}

<div class="wrap">



    <div class="container">
        {if isset($this->params['breadcrumbs'])}
            {Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs']
            ])}
        {/if}

        {if Yii::$app->session->hasFlash('alert')}

            <div class="alert alert-danger">
                {Html::encode(Yii::$app->session->getFlash('alert'))}
            </div>

        {/if}
        {if Yii::$app->session->hasFlash('info')}

            <div class="alert alert-info">
                {Html::encode(Yii::$app->session->getFlash('info'))}
            </div>

        {/if}

        {$content}
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right">{Yii::powered()}</p>
    </div>
</footer>

{$this->endBody()}
</body>
</html>
{$this->endPage()}
