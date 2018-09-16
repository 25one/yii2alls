<?php

namespace app\components;

use app\models\Mylogin;
use yii\base\Behavior;

class BehaviorLogin extends Behavior
{


    public function events()
    {
        return [
            Mylogin::EVENT_BEFORE_VALIDATE => 'MyBeforeValidate',
        ];
    }

    public function MyBeforeValidate($event)
    {

        if($event->sender->username=='serg') {  //...!!!$event->sender - опннапюг лндекх...
           $event->sender->addError('behavior', 'Error of validation for "serg"...');
        }

    }
}