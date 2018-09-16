<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\base\DynamicModel;

class Upload extends Model
{

    public $file;
    public $place;
    public $validation_error;

    public function rules()
    {
        return [
            //...
        ];
    }

    public function specialValidation($file)
    {
       $model = new DynamicModel(compact('file'));
       $model->addRule(['file'], 'file', ['extensions' => 'png,jpg,jpeg'])                
           ->validate();

       if (!$model->validate()) {
           return 'png,jpg,jpeg только';
       }

    }
}