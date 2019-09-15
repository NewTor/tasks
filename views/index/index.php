<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $statuses \app\models\Status::getAsArray() */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\Tasks */
/* @var $this yii\web\View */
$this->title = 'Задачи';
?>
<div class="site-index">
    <div class="body-content">
        <div id="modal-task"></div>
        <div class="row">
            <div class="col-md-10">
                <h2><?= $this->title;?></h2>
            </div>
            <div class="col-md-2 block__top-padding">
                <button type="button" id="btn__edit-task" class="btn btn-primary btn-xs">Новая задача</button>
            </div>
        </div>


        <div class="panel panel-info">
            <div class="panel-heading">
                <div id="filter-btn" style="cursor: pointer;"><strong>Фильтр</strong> <span class="caret"></span></div>
            </div>
            <div id="filter-block" class="panel-body" style="display: none;padding: 5px;">







                <div style="clear: both;"></div>
                <button type="submit" class="btn btn-primary btn-xs">Применить</button>
                <button type="reset" onclick="location.href='/index'" class="btn btn-primary btn-xs">Сброс</button>
            </div>
        </div>
        <?php
        Pjax::begin([
            'id'              => 'tasks-pjax',
            'timeout'         => 5000,
            'enablePushState' => true,
            'clientOptions'   => ['method' => 'POST'],
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
            'summary' => false,
            'columns' => [
                [
                    'format' => 'raw',
                    'attribute' => 'uuid',
                    'label' => 'UUID',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->uuid;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'name',
                    'label' => 'Задача',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->name;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'status_id',
                    'label' => 'Статус',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->status->status_name;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'tags',
                    'label' => 'Хэштеги',
                    'filter' => false,
                    'value' => function ($model) {
                        $result = '';
                        foreach ($model->tags as $tag) {
                            $result .= '#' . $tag->tag->tag_name . '; ';
                        }

                        return $result;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'priority',
                    'label' => 'Приоритет',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->priv;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'options' => [
                        'style' => 'width: 70px'
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) use ($user) {
                            return Html::a('', "javascript:spApplication.Action.editTask('$model->uuid')", ['class' => 'glyphicon glyphicon-pencil btn btn-primary btn-xs']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('', "javascript:spApplication.Action.deleteTask('$model->uuid')", ['class' => 'glyphicon glyphicon-remove btn btn-danger btn-xs']);
                        },
                    ]
                ],

            ],
        ]);
        Pjax::end();
        ?>
    </div>
</div>
