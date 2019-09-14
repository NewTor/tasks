<?php
use yii\helpers\Html;
/* @var $tag \app\models\Tags | null */
?>
<div class="row">
    <div class="col-md-12">
        <?= Html::label('Хэштег', 'tag_name');?>
        <?= Html::textInput('tag_name', $tag ? $tag->tag_name : '', ['class' => 'form-control', 'id' => 'tag_name']);?>
    </div>
</div>

