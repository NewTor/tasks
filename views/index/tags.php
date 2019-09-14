<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = 'Хэштеги';
?>
<div class="site-index">
    <div id="modal-tags"></div>
    <div class="body-content">
        <div class="row">
            <div class="col-md-10">
                <h2><?= $this->title;?></h2>
            </div>
            <div class="col-md-2 block__top-padding">
                <button type="button" id="btn__edit-tag" class="btn btn-primary btn-xs">Новый тег</button>
            </div>
        </div>
        <?php
        Pjax::begin([
            'id'              => 'tags-pjax',
            'timeout'         => 5000,
            'enablePushState' => true,
            'clientOptions'   => ['method' => 'POST'],
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
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
                    'attribute' => 'tag_name',
                    'label' => 'Хэштег',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->tag_name;
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
                            return Html::a('', "javascript:spApplication.Action.editTag($model->id)", ['class' => 'glyphicon glyphicon-pencil btn btn-primary btn-xs']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('', "javascript:spApplication.Action.deleteTag($model->id)", ['class' => 'glyphicon glyphicon-remove btn btn-danger btn-xs']);
                        },
                    ]
                ],
            ],
        ]);
        Pjax::end();
        ?>
    </div>
</div>
