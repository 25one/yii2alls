<?php
namespace app\components;

use yii\base\Behavior;

class MyBehavior extends Behavior
{

    private $prop;

    public function getProp()
    {
        return $this->prop;
    }

    public function setProp($value)
    {
        $this->prop = $value;
    }

    public function foo()
    {
        // ...
    }
}