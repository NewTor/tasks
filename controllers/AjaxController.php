<?php

namespace app\controllers;

use app\models\Status;
use app\models\Tasks;
use Yii;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * @return string
     */
    public function actionEditStatus()
    {
        $get = Yii::$app->request->get();
        $status = null;
        if($get && isset($get['id'])) {
            if($get['id'] != 0) {
                $status = Status::findOne($get['id']);
            }
        }
        return $this->renderAjax('edit_status', [
            'status' => $status,
        ]);
    }
    /**
     * @return string
     */
    public function actionEditStatusSave()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['id']) && isset($post['json'])) {
            $json_obj = json_decode($post['json']);
            if($post['id'] == 0) {
                $status = new Status();
            } else {
                $status = Status::findOne($post['id']);
            }
            $status->status_name = $json_obj->status_name;
            $status->save();
            if($status->save()) {
                return json_encode([
                    'error' => false,
                    'message' => '#' . $status->id,
                ]);
            } else {
                return json_encode([
                    'error' => true,
                    'message' => 'Ошибка сохранения данных',
                ]);
            }
        } else {
            return json_encode([
                'error' => true,
                'message' => 'Ошибка при отправке данных',
            ]);
        }
    }
    /**
     * @return string
     */
    public function actionDeleteStatus()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['id']) && $post['id'] != 0) {
            $rel_tasks = Tasks::findAll(['status_id' => $post['id']]);
            if(!empty($rel_tasks)) {
                return json_encode([
                    'error' => true,
                    'message' => 'К данному статусу привязаны задачи. Статус не может быть удален.',
                ]);
            } else {
                Status::deleteAll(['id' => $post['id']]);
                return json_encode([
                    'error' => false,
                    'message' => '#' . $post['id'],
                ]);
            }
        } else {
            return json_encode([
                'error' => true,
                'message' => 'Ошибка при отправке данных',
            ]);
        }
    }

}
