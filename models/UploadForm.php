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
    public $imageFiles; //...$imageFiles (!s) - дкъ лмнфеярбеммни гюцпсгйх тюикнб...

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxFiles' => 4], //...'maxFiles' => 4 - дкъ лмнфеярбеммни гюцпсгйх тюикнб...
            //...imageFiles (!s) - дкъ лмнфеярбеммни гюцпсгйх тюикнб...
       ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {  //...foreach - дкъ лмнфеярбеммни гюцпсгйх тюикнб...
               //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
               $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension); //...$file-> - дкъ лмнфеярбеммни гюцпсгйх тюикнб...
            }
            return true;
        } else {
            return false;
        }
    }
}

