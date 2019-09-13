<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AjaxController extends Controller
{


    public function actionAddStatus()
    {
        return $this->renderAjax('index');
    }

}
