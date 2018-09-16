<?php

//namespace app\components;
namespace app\filters;

use Yii;
use yii\base\ActionFilter;

class ActionDBFilter extends ActionFilter
{

    // ��� ������� ���������� �� ���������� ������
    public function beforeAction($action)
    {
       return parent::beforeAction($action);
    }

    // ��� ������� ���������� ����� ���������� ������
    public function afterAction($action, $result)
    {
       //print_r("Action '{$action->uniqueId}'...");
       $session = Yii::$app->session;
       //if($session->get('filter')=='start' or $session->get('filter')==1) {
       if($session->get('filter')=='start' or $session->get('filter')==1 or $session->get('filter')==2) {
          return parent::afterAction($action, $result);
       }
    }

/*...������ ������� ����� ���������� ��������...
    private $_startTime;

    public function beforeAction($action)
    {
        $this->_startTime = microtime(true);
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $time = microtime(true) - $this->_startTime;
        //Yii::debug("Action '{$action->uniqueId}' spent $time second.");
        print_r("Action '{$action->uniqueId}' spent $time second.");
        return parent::afterAction($action, $result);
    }
*/

}
