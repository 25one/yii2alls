<?php

namespace app\components;

use yii\data\BaseDataProvider;

class MyDataProvider extends BaseDataProvider
{


    //public $models;
    //public $count;

    public function init()
    {
        parent::init();

    }

    public function prepareModels()
    {

        $pagination = $this->getPagination();

        //$models=array('alex', 'serg', 'bob', 'marta');
        $models=array(0 => array('id' => 1, 'name' => 'alex'), 1 => array('id' => 2, 'name' => 'serg'), 2 => array('id' => 3, 'name' => 'bob'), 3 => array('id' => 4, 'name' => 'marta'));

        return $models;

    }

    public function prepareKeys($models)
    {

        //$keys = [0, 1, 2, 3];
        //...
        //return $keys;
        return [0, 1, 2, 3];

    }

    public function prepareTotalCount()
    {

        //$count=4;
        //...
        //return $count;
        return 4;

    }


}
