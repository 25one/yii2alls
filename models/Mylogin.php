<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\DynamicModel;

class Mylogin extends ActiveRecord
{

    public $title='Login of Citadel';

    public function rules()
    {

        return [
            //...,
        ];

    }

    public function Ajaxspecialvalidation($login, $pass)
    {
       $model = new DynamicModel(compact('login', 'pass'));
       $model->addRule(['login', 'pass'], 'required')
           ->validate();

       if (!$model->validate()) {
           return 'Bad format of field(s)...';
       }

    }

}
