<?php

namespace app\models;

//use yii\console\Controller;
//use app\models\Surprisenew;
use yii\base\Object;

class WriteJob extends Object implements \yii\queue\Job
{

    public $text;
    public $file;

    public function execute($queue)
    {
        file_put_contents($this->file, $this->text);
    }

}

