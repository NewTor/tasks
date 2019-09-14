<?php
use yii\helpers\Html;
/* @var $status \app\models\Status | null */
?>
<div class="row">
    <div class="col-md-12">
        <?= Html::label('Статус', 'status_name');?>
        <?= Html::textInput('status_name', $status ? $status->status_name : '', ['class' => 'form-control', 'id' => 'status_name']);?>
    </div>
</div>