<?php


namespace app\controllers;

use app\models\Chats;
use Yii;
use yii\web\Controller;
use app\models\ChatForm;
use yii\helpers\Json;

class ChatsController extends Controller
{


    public function actionChat()
    {

        $model = new ChatForm();

        if ($model->load(Yii::$app->request->post()) && $model->addText()) {
            $model = new ChatForm();
        }
        $chat = Chats::find()->where(['access'=>true])->all();
        $chat = Json::encode($chat);

        if (Yii::$app->user->can('admin')) {

            $fault = Chats::find()->where(['access'=>false])->all();
            $fault = Json::encode($fault);

            return $this->render('chat', [
                'chat' => $chat,
                'model' => $model,
                'fault' => $fault,
            ]);
        }
        else {
            return $this->render('chat', [
                'chat' => $chat,
                'model' => $model,
            ]);
        }


    }

    public function actionAddChat() {

        if (Yii::$app->user->can('admin')) {

            if (Yii::$app->request->post()) {
                $request = Yii::$app->request;
                $chats = new Chats();
                if ($request->post('add_id')) {
                    $chats->onAdd(Yii::$app->request->post('add_id'));
                    return $this->redirect(['chat']);
                }
                else return false;
            }
            else return false;
        }
        else return false;

    }

    public function actionDeleteChat() {

        if (Yii::$app->user->can('admin')) {

            if (Yii::$app->request->post()) {
                $request = Yii::$app->request;
                $chats = new Chats();
                if ($request->post('del_id')) {
                    $chats->onDelete(Yii::$app->request->post('del_id'));
                    return $this->redirect(['chat']);
                }
                else return false;
            }
            else return false;
        }
        else return false;

    }


    public function actionCheckChat() {

        if (Yii::$app->user->can('admin')) {

            if (Yii::$app->request->post()) {
                $request = Yii::$app->request;
                $chats = new Chats();
                if ($request->post('id')) {
                    $chats->onCheck(Yii::$app->request->post('id'));
                    return $this->redirect(['chat']);
                }
                else return false;
            }
            else return false;
        }
        else return false;
    }

}