<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\module\page\models\Page */

$this->title = Yii::t('page', 'Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('page', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
