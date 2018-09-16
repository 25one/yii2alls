<?php
namespace tests\unit;

use app\models\Country;

class HttpRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCountryRestApi()
    {

       $model = new Country; //...���� ������...

       $model->attributes = \Yii::$app->request->post('Country'); //...�� ���������...    
       //expect_that($model->code);     //!!!...��� ���� ��� ��� "Error"...
       expect_not($model->code);      //!!!...��� ���� ��� ��� "Success"...

    }

/*

namespace tests\models;
use app\models\EntryForm;
class EntryFormTest extends \Codeception\Test\Unit
{
  public function testValidInput()
  {
    $model = new EntryForm();
    $model->name = 'Harry Qin';
    $model->email = '15848778@qq.com';
    expect_that($model->validate());
    return $model;  //???
  }
  public function testInvalidInput()
  {
    $model = new EntryForm();
    $model->name = 'Harry Qin';
    $model->email = 'xxyy';
    expect_not($model->validate());
    $model = new EntryForm();
    $model->name = '';
    $model->email = '15848778@qq.com';
    expect_not($model->validate());
  }
  //
  // The following line indicates that the parameter values entered here are derived from testValidInput Output
  // @depends testValidInput
  //
  public function testModelProperty($model)
  {
    expect($model->name)->equals('Harry Qin');
  }
}

*/

}