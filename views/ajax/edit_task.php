<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $task \app\models\Tasks | null */
/* @var $statuses \app\models\Status */
?>
<script>
$(function () {
    /**
     * Поиск тега автокомплитом
     */
    $("#tag-name").autocomplete({
        source: "/ajax/search-tag",
        select: function (e, ui) {
            $("#tag-name").val(ui.item.label).data("tag", ui.item.value);
            return false;
        },
        minLength: 2
    });
    /**
     * Вставка/привязка тега
     */
    $("#tag-name__up").on("click", function () {
        var tag_id = $("#tag-name").data('tag');
        var uuid = "<?= $task->uuid;?>";
        var tag_name = $("#tag-name").val();
        $.ajax({async: false,
            url: "/ajax/bind-tag",
            type: "POST",
            data:({tag_id: tag_id, uuid: uuid, tag_name: tag_name}),
            success: function() {
                $("#tag-name").val('');
                $("#tags-wrapper").append('<span id="t' + tag_id + '" data-value="' + tag_id + '" class="label label-default tags">#' + tag_name + ' <span class="glyphicon glyphicon-remove"></span></span>');
            }
        });
    });
    /**
     * Отвязка тега от задачи
     */
    $(".tags").on("click", function () {
        var tag_id = $(this).data("value");
        var uuid = "<?= $task->uuid;?>";
        $.ajax({async: false,
            url: "/ajax/delete-task-tag",
            type: "POST",
            data:({tag_id: tag_id, uuid: uuid}),
            success: function() {
                $("#t" + tag_id).hide();
            }
        });
    });
});
</script>
<div class="row row-m__bottom">
    <div class="col-md-12">
        <?= Html::label('Задача', 'task_name');?>
        <?= Html::textarea('task_name', $task ? $task->name : '', ['class' => 'form-control', 'id' => 'task_name']);?>
    </div>
</div>
<div class="row row-m__bottom">
    <div class="col-md-6">
        <?= Html::label('Статус', 'status_id');?>
        <select id="status_id" class="form-control">
        <?php foreach ($statuses as $status): ?>
            <option <?= ($task && $task->status_id == $status->id) ? 'selected': ''?> value="<?= $status->id;?>"><?= $status->status_name;?></option>
        <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-6">
        <?= Html::label('Приоритет', 'prioritet');?>
        <select id="prioritet" class="form-control">
            <option <?= ($task && $task->priority == '0') ? 'selected': ''?> value="0">Низкий</option>
            <option <?= ($task && $task->priority == '1') ? 'selected': ''?> value="1">Средний</option>
            <option <?= ($task && $task->priority == '2') ? 'selected': ''?> value="2">Высокий</option>
        </select>
    </div>
</div>
<?php if($task):?>
    <div class="row row-m__bottom">
        <div class="col-md-12" style="padding: 5px;">
            <div id="tags-wrapper">
                <?php foreach($task->tags as $tag):?>
                    <span id="t<?= $tag->tag_id;?>" data-value="<?= $tag->tag_id;?>" class="label label-default tags">#<?= $tag->tag->tag_name;?> <span class="glyphicon glyphicon-remove"></span></span>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="text" id="tag-name" data-tag="0" class="form-control input-sm" placeholder="" style="float: left;width: 92%;">
            <button class="btn btn-primary btn-xs" id="tag-name__up" type="button" style="float: left;"><span class="glyphicon glyphicon-arrow-up"></span></button>
        </div>
    </div>
<?php endif;?>
