<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\module\page\models\Page */

$this->title = Yii::t('page', 'Update {modelClass}: ', [
    'modelClass' => 'Page',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('page', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('page', 'Update');
?>
<div class="page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
