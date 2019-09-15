<?php
use yii\helpers\Html;
/* @var $task \app\models\Tasks | null */
/* @var $statuses \app\models\Status */
?>
<div class="row" style="margin-bottom: 5px;">
    <div class="col-md-12">
        <?= Html::label('Задача', 'name');?>
        <?= Html::textarea('name', $task ? $task->name : '', ['class' => 'form-control', 'id' => 'name']);?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= Html::label('Статус', 'status_id');?>
        <select id="status_id" class="form-control">
        <?php foreach ($statuses as $status): ?>
            <option <?= ($task && $task->status_id == $status->id) ? 'selected': ''?> value="<?= $status->id;?>"><?= $status->status_name;?></option>
        <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-6">
        <?= Html::label('Приоритет', 'priority');?>
        <select id="priority" class="form-control">
            <option <?= ($task && $task->priority == '0') ? 'selected': ''?> value="0">Низкий</option>
            <option <?= ($task && $task->priority == '1') ? 'selected': ''?> value="1">Средний</option>
            <option <?= ($task && $task->priority == '2') ? 'selected': ''?> value="2">Высокий</option>
        </select>
    </div>
</div>
<?php if($task):?>


555

<?php endif;?>
