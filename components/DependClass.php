<?php

namespace app\components;

//use app\models\Mymodbase;
use app\models\Basemod;  //...ДЛЯ Dependency Injection Container...

class DependClass
{

    public $modelbase;

    public function __construct(Basemod $modelbase)
    {
       $this->modelbase=$modelbase;
    }
}