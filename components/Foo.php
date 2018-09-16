<?php

namespace app\components;

use yii\base\Component;
use yii\base\Event;

class Foo extends Component
{

    const EVENT_HELLO = 'Hi event...';   //...$event->name

    public function bar()
    {
        $this->trigger(self::EVENT_HELLO);  //...ВЫЗЫВАЕТ ТО, ЧТО on К НЕМУ(EVENT_HELLO) ПРИКРЕПИЛ...
    }                                       //...($foo->on(Foo::EVENT_HELLO, function ($event) {... - Т.Е. ТУТ - АНОНИМНАЯ ФУНКЦИЯ)

}

