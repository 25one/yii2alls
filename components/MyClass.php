<?php

namespace app\components;

use yii\base\BaseObject;
use yii\helpers\Html;
//use yii\base\Component;
//use yii\base\Event;

/*
class Foo extends Component
{

    const EVENT_HELLO = 'hello';

    public function bar()
    {
        $this->trigger(self::EVENT_HELLO);
    }

}
*/

class MyClass extends BaseObject
//class MyClass extends Component
{

/*
    public $prop1;
    public $prop2;

    public function __construct($param1, $param2, $config = [])
    {
        // ... инициализация происходит перед тем, как будет применена конфигурация.

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        // ... инициализация происходит после того, как была применена конфигурация.
    }
*/

	public $content;
    private $label;

    //const EVENT_HELLO = 'hello';

	public function init(){ // функция инициализации - ВЫПОЛНЯЕТСЯ ПЕРВОЙ!. Если данные не будут переданы в компонент, то он выведет текст "Текст по умолчанию"
		parent::init();     //...ОБЯЗАТЕЛЬНО В НАЧАЛЕ...
		$this->content= 'Текст по умолчанию';
	}

    public function display($content=null){ // функция отображения данных - $content=null - ФЛАГ - МОЖНО НЕ ПЕРЕДАВАТЬ НИЧЕГО-УСЛОВИЕ СРАБОТАЕТ...
		if($content!=null){ //проверка строки на пустоту
			$this->content= $content;
		}
		echo Html::encode($this->content); // вывод данных
	}

    //...ГЕТТЕРЫ-СЕТТЕРЫ...
    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($value)
    {
        $this->label = mb_strtoupper($value);
    }
    //...ГЕТТЕРЫ-СЕТТЕРЫ...

}
