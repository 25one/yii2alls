<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Worker extends ActiveRecord
{

    public $id_projects;

    public function rules()
    {
       return [
          [['name'], 'required', 'message' => 'поле ФИО-обязательно'],
       ];
    }

}
