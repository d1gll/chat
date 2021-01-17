<?php

namespace app\models;

use app\models\Chats;
use Yii;
use yii\base\Model;
use app\components\behaviors\PurifyBehavior;

class ChatForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            ['text', 'required', 'message' => ''],
            ['text', 'trim'],
            ['text', 'string', 'max' => 100],

        ];
    }

    public function behaviors()
    {
        return [
            'purify' => [
                'class' => PurifyBehavior::className(),
                'attributes' => ['text'],
            ]
        ];
    }


    public function addText()
    {

        if ($this->validate()) {
            if (Yii::$app->user->can('editor')) {
                $rule = "editor";
            }
            if (Yii::$app->user->can('admin')) {
                $rule = "admin";
            }
            $chat = new Chats();
            $chat->username = Yii::$app->user->identity->username;
            $chat->text = $this->text;
            $chat->rules = $rule;
            $chat->tdata = date("d.m.y H:i");
            return $chat->save() ? $chat : null;
        }
    }

}

