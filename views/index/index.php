<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Задачи';
?>
<div class="site-index">

    <div class="body-content">
        <h2><?= $this->title;?></h2>


        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'integer',
                    'label' => 'Identifier',
                    'options' => [
                        'style' => 'width: 70px'
                    ]
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'name',
                    'label' => 'Задача',
                    'filter' => true,
                    'value' => function ($model) {
                        return $model->name;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'status_id',
                    'label' => 'Статус',
                    'filter' => [],
                    'value' => function ($model) {
                        return $model->status_id;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'tags',
                    'label' => 'Теги',
                    'filter' => [],
                    'value' => function ($model) {
                        //var_dump($model->tags);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'priority',
                    'label' => 'Приоритет',
                    'filter' => [
                        '0' => 'Низкий',
                        '1' => 'Средний',
                        '2' => 'Высокий',
                    ],
                    'value' => function ($model) {
                        return $model->priority;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) use ($user) {
                            return Html::a('', "javascript:deleteProduct($model->id)", ['class' => 'glyphicon glyphicon-pencil btn btn-primary btn-xs']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('', "javascript:deleteProduct($model->id)", ['class' => 'glyphicon glyphicon-remove btn btn-danger btn-xs']);
                        },
                    ]
                ],

            ],
        ]);
        ?>




    </div>
</div>
