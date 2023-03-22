<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\patrons $model */

$this->title = 'Update Patrons: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patrons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="patrons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
