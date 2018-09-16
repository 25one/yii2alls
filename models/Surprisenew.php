<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\base\DynamicModel;
use app\components\behaviors\CachedBehavior;

class Surprisenew extends ActiveRecord
{

   public $title='Login of Citadel';
   public $username; 

    public function behaviors()
    {
        parent::behaviors();
        return [
                'CachedBehavior' => [
                'class' => CachedBehavior::className(),
                //'cache_id' => ['cache'],
                //'cache_id' => ['surprisenew'],
                ],
        ];
    }

   public function rules() {

        return [
            [['id'], 'integer'],
            [['name', 'limit_for_all', 'limit_for_one', 'status'], 'required'],
            [['limit_for_all', 'limit_for_one', 'status'], 'integer'],
            ['status', 'in', 'range' => [0, 1]],

        ];

   }

    public function Ajaxspecialvalidation($name, $limit_for_all, $limit_for_one, $status)
    {
       $model = new DynamicModel(compact('name', 'limit_for_all', 'limit_for_one', 'status'));
       $model->addRule(['name', 'limit_for_all', 'limit_for_one', 'status'], 'required')
             ->addRule(['limit_for_all', 'limit_for_one', 'status'], 'integer')
             ->addRule(['status'], 'in', ['range' => [0, 1]])
           ->validate();

       if (!$model->validate()) {
           return 'Bad format of field(s)...';
       }

    }

}
