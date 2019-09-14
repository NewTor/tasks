<?php

namespace app\controllers;

use app\models\Status;
use app\models\Tags;
use app\models\Tasks;
use Yii;
use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Tasks();
        return $this->render('index', [
            'dataProvider' => $model->search (Yii::$app->request->get()),
            'searchModel' => $model,
            'statuses' => Status::getAsArray(),
        ]);
    }
    /**
     * Displays status page.
     *
     * @return string
     */
    public function actionStatus()
    {
        return $this->render('status');
    }
    /**
     * Displays status page.
     *
     * @return string
     */
    public function actionTags()
    {
        return $this->render('tags');
    }


}
