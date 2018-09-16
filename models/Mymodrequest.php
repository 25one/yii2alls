<?php

namespace app\models;

use Yii;
//use yii\db\ActiveRecord;
//use yii\web\NotFoundHttpException;

//class Mymodrequest extends Models //!!!...ЕСЛИ БЕЗ ПРИВЯЗКИ К КОКРЕТНОЙ ТАБЛИЦЕ... - ???ОШИБКА - НЕ РАБОТАЕТ ...extends Models
class Mymodrequest
//class Mymodrequest extends ActiveRecord
{

    public $requestexample;

    /*
    public function rules()
    {
        return [
            [['guest'], 'required'],
        ];
    }
    */

    public function requestExample()
	{

        $request = \Yii::$app->request;  //...!!! + use Yii; ИЛИ \Yii - ...!!!ЗАПРОС...
        $response = \Yii::$app->response; //...!!!ОТВЕТ...

        //print_r($_GET); echo '- GET<br>';
        //print_r($_POST); echo '- POST<br>';
        //print_r($request->bodyParams); echo '- ТИПА ТО ЖЕ, ЧТО И $request->post("Mymod") - ТОЛЬКО POST(?PUT, PATCH), НО НЕ GET<br>';

        //if($request->get()) {   // эквивалентно: $get = $_GET;, !!!...НО ЕСТЬ ЕЩЕ [r] => mymod/requestpage, ЧТО НЕ ПОКАЗАТЕЛЬ...

        //if($response->statusCode==200 and $request->get('guest')) {   // эквивалентно: $id = isset($_GET['id']) ? $_GET['id'] : null; !!!...А ВОТ ЭТО ДА...
        $session = \Yii::$app->session;
        if($session->get('hello')=='yes' and $request->get('guest')) {
            //return \Yii::$app->response->statusCode; //...200...

            //return $request->get('guest').' - get';  //...get...

            $arr_data['title']=$request->get('guest');
            $arr_data['method']='get';
            return $arr_data;

            //$response->format = \yii\web\Response::FORMAT_JSON; //...ТИПА ДЛЯ "ВНУТРЕННИЙ" json...(НО, ВСЯ ВЕРСТКА...)  
            //$response->data = ['message' => $request->get('guest').' - get'];
            //return $response->data;

            //$arr_data['json']=$request->get('guest').' - get'; //...ТИПА ДЛЯ json...(НО, ЗАЧЕМ...)
            //return json_encode($arr_data['json']);

            //return $request->url; //...ИЛИ absoluteUrl - ВЕСЬ С ХОСТОМ...
            //return $request->headers->get('User-Agent'); //...+ЗАГОЛОВКИ - Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36
            //return $request->userIP; //...+IP ПОЛЬЗОВАТЕЛЯ(46.149.80.128)...
        }
        //else if($response->statusCode!=200 and $request->get('guest')) {
        else if($session->get('hello')!='yes' and $request->get('guest')) {
           throw new \yii\web\NotFoundHttpException;  //...СТРАНИЦА ИСКЛЮЧЕНИЯ - ОШИБКА ЗАПРОСА...
        }
        //}
        //$id = $request->get('id', 1);
        // эквивалентно: $id = isset($_GET['id']) ? $_GET['id'] : 1;

        /*...ЭТО НЕ СОВСЕМ ТО...
        $post = $request->post();
        // эквивалентно: $post = $_POST;
        $name = $request->post('name');
        // эквивалентно: $name = isset($_POST['name']) ? $_POST['name'] : null;
        $name = $request->post('name', '');
        // эквивалентно: $name = isset($_POST['name']) ? $_POST['name'] : '';
        */
        if($request->post('Mymod')) {  //...!!!ВОТ ТАК...
            //return $request->post('Mymod')['guest'].' - '.$request->absoluteUrl.' - post';  //...!!!post...(url - ЧАСТЬ БЕЗ ХОСТА...)
            //return $request->headers->get('User-Agent'); //...ЗАГОЛОВКИ ЕСТЬ И ПРИ post...

            $arr_data['title']=$request->post('Mymod')['guest'];
            $arr_data['method']='post';
            return $arr_data;

        }
        //...+ [_csrf] => 8pqHooyKEw8jtnGeN_98MPTADXrrRgpoBAKTK4Up3Ze87O_72esiZ1ThO6xiiUlCrLVPF4MOXwlsMaF7xmeM8g==

	}

}

