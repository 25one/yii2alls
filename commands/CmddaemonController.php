<?php

namespace app\commands;

use yii\console\Controller;
//use app\models\Surprisenew;

class CmddaemonController extends Controller
{

    public $parametr = true;

    // php yii cmddaemon/daemon
    public function actionDaemon()
    {

        $i = 0;
        while($this->parametr) {
           echo date('H:i:s') . "\n";
           sleep(2);
           $i++;
           if($i == 4) {
              $this->parametr = false;
           }
        }

    }

}

