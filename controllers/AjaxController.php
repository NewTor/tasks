<?php

namespace app\controllers;

use app\models\Status;
use app\models\Tags;
use app\models\TagsTasks;
use app\models\Tasks;
use Yii;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * Модальное окно редактирования статуса
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
     * Экшн сохранения данных статуса
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
     * Экшн удаления статуса
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
    /**
     * Модальное окно редактирования тега
     *
     * @return string
     */
    public function actionEditTag()
    {
        $get = Yii::$app->request->get();
        $tag = null;
        if($get && isset($get['id'])) {
            if($get['id'] != 0) {
                $tag = Tags::findOne($get['id']);
            }
        }
        return $this->renderAjax('edit_tag', [
            'tag' => $tag,
        ]);
    }
    /**
     * Экшн сохранения данных тега
     * @return string
     */
    public function actionEditTagSave()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['id']) && isset($post['json'])) {
            $json_obj = json_decode($post['json']);
            $exists = Tags::findOne(['tag_name' => $json_obj->tag_name]);
            if($post['id'] == 0) {
                $tag = new Tags();
            } else {
                $tag = Tags::findOne($post['id']);
            }
            $tag->tag_name = $json_obj->tag_name;
            if(!$exists) {
                if($tag->save()) {
                    return json_encode([
                        'error' => false,
                        'message' => '#' . $tag->id,
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
                    'message' => 'Тег уже существует',
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
     * Экшн удаления тега
     * @return string
     */
    public function actionDeleteTag()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['id']) && $post['id'] != 0) {
            Tags::deleteAll(['id' => $post['id']]);
            TagsTasks::deleteAll(['tag_id' => $post['id']]);
            return json_encode([
                'error' => false,
                'message' => '#' . $post['id'],
            ]);
        } else {
            return json_encode([
                'error' => true,
                'message' => 'Ошибка при отправке данных',
            ]);
        }
    }
    /**
     * Модальное окно редактирования задачи
     * @return string
     */
    public function actionEditTask()
    {
        $get = Yii::$app->request->get();
        $task = null;
        if($get && isset($get['id'])) {
            $task = Tasks::findOne(['uuid' => $get['id']]);
        }
        return $this->renderAjax('edit_task', [
            'task' => $task,
            'statuses' => Status::find()->all(),
        ]);
    }
    /**
     * Экшн сохранения данных задачи
     * @return string
     */
    public function actionEditTaskSave()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['id']) && isset($post['json'])) {
            $json_obj = json_decode($post['json']);
            $connection = \Yii::$app->db;
            if($post['id'] == 0) {
                $sql = "CALL sp_InsertTask(". $json_obj->status_id .", '" . $json_obj->name . "', '" . $json_obj->priority . "')";
            } else {
                $task = Tasks::findOne(['uuid' => $post['id']]);
                $sql = "CALL sp_UpdateTask(". $json_obj->status_id .", '" . $json_obj->name . "', '" . $json_obj->priority . "', " . $task->id . ")";
            }
            $connection->createCommand($sql)->execute();
            return json_encode([
                'error' => false,
                'message' => $post['id'],
            ]);
        } else {
            return json_encode([
                'error' => true,
                'message' => 'Ошибка при отправке данных',
            ]);
        }
    }
    /**
     * Экшн удаления задачи
     * @return string
     */
    public function actionDeleteTask()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['id']) && $post['id'] != '') {
            $task = Tasks::findOne(['uuid' => $post['id']]);
            if($task) {
                TagsTasks::deleteAll(['task_id' => $task->id]);
                Tasks::deleteAll(['id' => $task->id]);
                return json_encode([
                    'error' => false,
                    'message' => $post['id'],
                ]);
            } else {
                return json_encode([
                    'error' => true,
                    'message' => 'Не существующая задача',
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
     * Searching tags
     * @return string
     */
    public function actionSearchTag()
    {
        return Tags::searchAutocomplete();
    }
    /**
     * Экшн привязки к задаче тега
     * @return string
     */
    public function actionBindTag()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['tag_id']) && $post['uuid'] != '' && $post['tag_name'] != '') {
            $task = Tasks::findOne(['uuid' => $post['uuid']]);
            if($task) {
                if($post['tag_id'] == 0) {
                    $tag = new Tags();
                    $tag->tag_name = $post['tag_name'];
                    $tag->save();
                } else {
                    $tag = Tags::findOne(['id' => $post['tag_id']]);
                }
                $task_tag = new TagsTasks();
                $task_tag->tag_id = $tag->id;
                $task_tag->task_id = $task->id;
                $task_tag->save();
                return json_encode([
                    'error' => false,
                    'message' => '',
                ]);
            } else {
                return json_encode([
                    'error' => true,
                    'message' => 'Задача не найдена',
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
     * Экшн удаления привязанного к задаче тега
     * @return string
     */
    public function actionDeleteTaskTag()
    {
        $post = Yii::$app->request->post();
        if($post && isset($post['tag_id']) && $post['uuid'] != '') {
            $task = Tasks::findOne(['uuid' => $post['uuid']]);
            if($task) {
                TagsTasks::deleteAll(['tag_id' => $post['tag_id'], 'task_id' => $task->id]);
                return json_encode([
                    'error' => false,
                    'message' => '#' . $post['tag_id'],
                ]);
            } else {
                return json_encode([
                    'error' => true,
                    'message' => 'Задача не найдена',
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
