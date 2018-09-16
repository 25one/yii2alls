<?php

//namespace app\components;
namespace app\widgets;   //...app - ÊÀÒÀËÎÃ ÏÐÈËÎÆÅÍÈß ÂÎÎÁÙÅ, yii - ÊÀÒÀËÎÃ vender ÑÀÌÎÃÎ yii...

use yii\base\Widget;  //...ÑÒÀÍÄÀÐÒÍÎ ÄËß Widget...
use yii\helpers\Html; //...ÄËß Html::encode...

class HelloWidget extends Widget
{

    public $message;
    public $id_user;
    public $patch='';

    public function init()
    {

        parent::init(); //...???...
        if($this->id_user==1) {
           $this->patch = 'hello';
        }
        else if($this->id_user==2) {
           $this->patch = 'nature';
        }

    }

    public function run()
    {

        //return Html::encode($this->message);
        return $this->render($this->patch);

    }

/*
    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        return Html::encode($content);
    }
*/

}
