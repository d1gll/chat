<?php

namespace app\models;

use yii\db\ActiveRecord;


class Chats extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%chats}}';
    }


    public function onCheck($id){

        $message = self::findOne(['id' => $id]);
        if($message){
            $message->access = false;
            $message->save();
            return true;
        }
        return false;

    }

    public function onAdd($id){

        $message = self::findOne(['id' => $id]);
        if($message){
            $message->access = true;
            $message->save();
            return true;
        }
        return false;

    }

    public function onDelete($id){

        $message = self::findOne(['id' => $id]);
        if($message){
            $message->delete();
            return true;
        }
        return false;

    }

}