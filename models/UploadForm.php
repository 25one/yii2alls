<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    //public $imageFile;
    public $imageFiles; //...$imageFiles (!s) - ��� ������������� �������� ������...

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxFiles' => 4], //...'maxFiles' => 4 - ��� ������������� �������� ������...
            //...imageFiles (!s) - ��� ������������� �������� ������...
       ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {  //...foreach - ��� ������������� �������� ������...
               //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
               $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension); //...$file-> - ��� ������������� �������� ������...
            }
            return true;
        } else {
            return false;
        }
    }
}

