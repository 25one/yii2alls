<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
//use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */

    public $message;

    public function options($actionID)
    {
        return ['message'];

    }

    //public function actionIndex($message = 'hello world')
    // php yii hello -message=hello
    public function actionIndex()
    {
        echo $this->message . "\n";

        //return ExitCode::OK;
    }

    // php yii hello/create test גûחמגוע "actionCreate('test')
    public function actionCreate($name)
    {
       echo $name . "\n";
    }

    // php yii hello/category city גûחמגוע actionCategory('city', 'name')
    // php yii hello/category city id גûחמגוע actionCategory('city', 'id')
    public function actionCategory($category, $order = 'name')
    {
       echo $category.' - '.$order. "\n";
    }

    // php yii hello/add test גûחמגוע actionAdd(['test']) !!![...]
    // php yii hello/add test1,test2 גûחמגוע actionAdd(['test1', 'test2']) !!!...,... + [...]
    public function actionAdd(array $name)  //!!!array
    {
       print_r($name). "\n";
    }



}

