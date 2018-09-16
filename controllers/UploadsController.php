<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Uploads;
use yii\web\UploadedFile;
use yii\imagine\Image;    

class UploadsController extends Controller
{
    public function actionIndex()
    {
        $model_uploud = new Uploads();

        if (Yii::$app->request->isPost) {
            $model_uploud->file = UploadedFile::getInstance($model_uploud, 'file');
            if ($model_uploud->file && !$model_uploud->specialValidation($model_uploud->file)) {
                $model_uploud->file->saveAs('img/' . date('YmdHis') . $model_uploud->file->baseName . '.' . $model_uploud->file->extension);
                Image::thumbnail(Yii::$app->basePath . '/web/img/' . date('YmdHis') . $model_uploud->file->baseName . '.' . $model_uploud->file->extension, 200, 200)
                ->save(Yii::$app->basePath . '/web/img/' . date('YmdHis') . $model_uploud->file->baseName . '.' . $model_uploud->file->extension,
                  ['quality' => 80]);
                $model_uploud->place = 'img/' . date('YmdHis') . $model_uploud->file->baseName . '.' . $model_uploud->file->extension;
            }
            else if($model_uploud->file && $model_uploud->specialValidation($model_uploud->file)){
                $model_uploud->validation_error = $model_uploud->specialValidation($model_uploud->file);
            }
        }
        return $this->renderPartial('upload', ['model_uploud' => $model_uploud]);
    }
}