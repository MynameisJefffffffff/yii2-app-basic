<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\patrons $model */

$this->title = 'Create Patrons';
$this->params['breadcrumbs'][] = ['label' => 'Patrons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
