<?php

namespace app\controllers;

use Yii;                      //!!!\Yii::$app->request->post('Mymod'); ...
use yii\web\Controller;
use app\models\Mymod;
use app\models\Mymodbase;  //...РАСШИРЕНИЕ МОДЕЛИ...
use app\models\Mymodrequest;  //...РАСШИРЕНИЕ МОДЕЛИ...
use app\filters\ActionDBFilter;
use yii\filters\VerbFilter;
use yii\filters\HttpCache;
use yii\base\Event;
//use app\components\DependClass;  //...ПРЯМО В get Dependency Injection Container... 
use yii\di\Container;

class MymodController extends Controller
{

    public $layout = 'base'; //...!!!ОПРЕДЕЛЕНИЕ ШАБЛОНА layouts/base.php...

    //public $modelbase;

    //public function __construct(Mymodbase $modelbase)
    //{
    //    //$this->modelbase=$modelbase;
    //}

    public function behaviors()
    {

        return [

        'access_db' => [    //...???
                //'class' => 'yii\filters\ActionDBFilter',  //...НЕ yii/...
                //'class' => 'app\filters\ActionDBFilter',  //...ИЛИ ТАК - ТОГДА БЕЗ use app\filters\ActionDBFilter;
                'class' => ActionDBFilter::className(),     //...ИЛИ ТАК - ТОГДА С use app\filters\ActionDBFilter;
                //'only' => ['hello'],                      //...ЕСЛИ НУЖНО, НО url...
            ],

            /*
            'verbs' => [
                'class' => VerbFilter::className(), //...!!!ЭТО СТАНДАРТНЫЙ ФИЛЬТР (проверяет, разрешено ли запросам HTTP выполнять затребованные ими действия)
                'actions' => [                      //... + use yii\filters\VerbFilter;
                    //'index' => ['get'],    //...!!!ТАК "ДА", НО ТОЛЬКО НАЧАЛЬНАЯ...
                    'index' => ['get', 'post'],    //...!!!ТАК ВСЕ...
                ],
            ],
            */

            /*
            [   //...Чтобы использовать кэширование на стороне клиента, вы можете настроить yii\filters\HttpCache в качестве фильтра для действия контроллера
                'class' => 'yii\filters\HttpCache',             //...БУДЕТ В КЕШИРОВАНИИ...
                'only' => ['index', 'view'],                    //...+ use yii\filters\HttpCache;
                'lastModified' => function ($action, $params) { //...+ !ВНИМАНИЕ - БЕЗ ЯВНОГО ТИПА verbs' => [...
                    $q = new \yii\db\Query();
                    return $q->from('mymod')->max('id');
                },
            ],
            */
        ];

    }

    public function actionIndex()
    {

        //$connection=\Yii::$app->db;  //!!!...ДЛЯ ВОЗМОЖНОСТИ ПРОСТО ПИСАТЬ ЗАПРОСЫ "РУКАМИ"(ЧТО ЧАСТО УДОБНЕЕ) - ?!СЕЙЧАС В МОДЕЛИ...

        //print_r($this->access_db);

        $model=new Mymod;

        //$modelbase=new Mymodbase;  //...РАСШИРЕНИЕ МОДЕЛИ - ИЛИ Dependency Injection Container - НИЖЕ...

        $container=new Container;  //...Dependency Injection Container - НИЖЕ...
        $basemodd = $container->get('app\components\DependClass');
        $basemod=$basemodd->modelbase;
        //print_r($basemod); die;

        //$model=new \app\models\Mymod;  //...ИЛИ ТАК - ТОГДА use app\models\Mymod; НЕ НУЖНО...

        $session = Yii::$app->session;

        if ($model->load(Yii::$app->request->post())) {  //!!!...ПРОВЕРКА НАЖАТИЯ КНОПКИ...(?НО ТУТ БЕЗ 'Mymod'))
        //$model->attributes = \Yii::$app->request->post('Mymod'); //!!!...ИЛИ ТАК...
        //if (!empty($model->attributes['login'])) {               //!!!...+ТАК...НО ЛУЧШЕ ТИПА КАК ВЫШЕ...
           //$model->attributes = \Yii::$app->request->post('Mymod');   //!!!...НЕ ОБЯЗАТЕЛЬНО - И ТАК ЕСТЬ...
           //print_r($model->attributes); echo '<br>'; die;
           //print_r($model->toArray()); echo '<br>'; die;   //...ИЗ fields() В МОДЕЛИ - !ПОЛЯ, НЕ АТРИБУТЫ...
           if ($model->validate()) {
              $string_sql='select * from mymod where login=:login and password=:password';
              $params = [':login' => $model->attributes['login'], ':password' => $model->attributes['password']];
              //print_r($params); die;

              \Yii::beginProfile('myBenchmark', 'klisl');  //...ЗАМЕР ПРОИЗВОДИТЕЛЬНОСТИ...

              //$row_db_result=$model->connectionDB($string_sql, $params);    //...ЭТО ЧЕРЕЗ МОДЕЛЬ...

              //...ИЛИ АЛЬТЕРНАТИВА - ЧЕРЕЗ Acrive Record + ЗДЕСЬ ЖЕ В КОНТРОЛЛЕРЕ ВМЕСТО МОДЕЛИ (???ЧТО ВЕРНЕЕ - МОДЕЛЬ...)
              $login = Yii::$app->request->post('Mymod')['login'];       //...ТУТ ЗАЩИТА ЕСТЬ - post(... - !!!post('Mymod')['login']
              $password = Yii::$app->request->post('Mymod')['password']; //...ТУТ ЗАЩИТА ЕСТЬ - get(...
              //print_r($login); echo '<br>';
              //print_r($password); echo '<br>';
              //die;
              //$row_db_result=$model->findOne(1);
              //print_r($row_db_result->login); die; //...ТОГДА...
              $row_db_result=$model->find()->active($login, $password)      //!!!!!...ВОТ ОЧЕНЬ ИНТЕРЕСНО - ПЕРЕОПРЕДЕЛИТЬ find (В МОДЕЛИ)
                //->where(['login' => $login, 'password' => $password])     //... + ВМЕСТО where ТУТ СДЕЛАТЬ ТАМ (РАСШИРЕНИЕ ЗАПРОСОВ...)
                ->asArray()->all();
              //print_r($row_db_result[0]['login']); die; //...Т.К. asArray()...
              //print_r($row_db_result); die;

              //...СВЯЗИ Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...
              // SELECT * FROM `mymod` WHERE `id` = $row_db_result[0]['id']
              //$user = $model->findOne(1);
              $user = $model->findOne($row_db_result[0]['id']);
              // SELECT * FROM `mymodorder` WHERE `user_id` = $row_db_result[0]['id']
              // $orders - это массив объектов Order
              //$orders = $user->orders; //...!!!ВСЕ - ГЕТТЕР...
              //...!!!ТОНКАЯ ПОДСТРОЙКА ЗАПРОСА => SELECT * FROM `mymodorder` WHERE `user_id` = $row_db_result[0]['id'] and `order` like '2'
              $orders = $user->getOrders() //...!!!НО, ТОГДА НЕ ГЕТТЕР, А getOrders()...
                 ->where(['like', 'order', '2'])
                 //->orderBy('id')
                 ->all();
              //...!!!ТОНКАЯ ПОДСТРОЙКА ЗАПРОСА => SELECT * FROM `mymodorder` WHERE `user_id` = $row_db_result[0]['id'] and `order` like '2'

              //...!!!ЖАДНАЯ ЗАГРУЗКА - ОБРАЗНО НЕ 101 ЗАПРОС => IN ...
              /*
              // SELECT * FROM `customer` LIMIT 100;
              // SELECT * FROM `orders` WHERE `customer_id` IN (...)
              $users = $model->find()  //...БЫЛО $user = $model->findOne($row_db_result[0]['id']);
                  ->with('orders')
                  ->limit(100)
                  ->all();
              foreach ($users as $user) {
                 // SQL-запрос не выполняется - !!!!!
                 $orders = $user->orders;  //...БЫЛО $orders = $user->orders; //...!!!ВСЕ - ГЕТТЕР...
                 foreach ($orders as $k=>$order) {
                    //print_r($order->attributes); echo '<br>';
                    $order_title[]=$order->attributes['order'];
                 }
              }
              */
              //...!!!ЖАДНАЯ ЗАГРУЗКА - ОБРАЗНО НЕ 101 ЗАПРОС => IN ...

              //......ТИПА JOIN - НО ГЕММОР...
              /*
              $orders = $model->find()
                 ->joinWith('orders')
                 //->where(['mymodorder.user_id' => 2])
                 ->where(['like', '`mymodorder`.`order`', 'serg'])
                 ->all();

              print_r($orders); die;
              foreach ($orders as $k=>$order) {
                  //print_r($order->attributes); echo '<br>';
                   $order_title[]=$order->attributes['order'];
              }
              */
              //......ТИПА JOIN - НО ГЕММОР...

              foreach ($orders as $k=>$order) {
                 //print_r($order->attributes); echo '<br>';
                 $order_title[]=$order->attributes['order'];
              }

              //print_r($order_title); echo '<br>';
              //die;
              //...СВЯЗИ Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...

              //...ДОПОЛНИТЕЛЬНЫЙ АТРИБУТ - count...
              $counts = $model->find()
                ->select([
                    '{{mymod}}.*', // получить все атрибуты покупателя
                    'COUNT({{mymodorder}}.id) AS ordersCount' // вычислить количество заказов
                ])
                ->joinWith('orders') // обеспечить построение промежуточной таблицы
                ->groupBy('{{mymod}}.id') // сгруппировать результаты, чтобы заставить агрегацию работать
                ->all();
              //print_r($counts['ordersCount']); die;
              //print_r($counts); die;
              foreach ($counts as $k=>$count) {
                 print_r($count->attributes['login'].' - '.$count['ordersCount']); echo '<br>';
                 //$order_title[]=$order->attributes['order'];
              }
              //die;
              //...ДОПОЛНИТЕЛЬНЫЙ АТРИБУТ - count...

              //...Active Record - ОБЪЕКТ...
              /*
              //foreach (Mymod::find()->batch(10) as $k=>$users) { //...???...
              foreach (Mymod::find()->each(10) as $k=>$users) {
                // $users - это массив, в котором находится 10 или меньше объектов класса Mymod
                //print_r($users[0]->title); echo '<br>';
                //print_r($k); echo ' - ';
                print_r($users->attributes); echo '<br>';  //...!!!$users->attributes...
              }
              die;
              */
              //...Active Record - ОБЪЕКТ...

              //...ИЛИ АЛЬТЕРНАТИВА - ЧЕРЕЗ Acrive Record + ЗДЕСЬ ЖЕ В КОНТРОЛЛЕРЕ ВМЕСТО МОДЕЛИ (???ЧТО ВЕРНЕЕ - МОДЕЛЬ...)

              //...ТРАНЗАКЦИИЮ - НЕСКОЛЬКО ЗАПРОСОВ ВМЕСТЕ...
              /*
              $model->getDb()->transaction(function($db) use ($model) {
              $model->id = 3; //...INSERT...
              $model->save();
              $model->id = 4; //...UPDATE...
              $model->save();
              // ...другие операции с базой данных...
              });
              */
              //...ТРАНЗАКЦИИЮ - НЕСКОЛЬКО ЗАПРОСОВ ВМЕСТЕ...

              //for($a=0; $a<1000000; $a++){}  //...ДЛЯ НАГЛЯДНОСТИ ЗАМЕРА...
              \Yii::endProfile('myBenchmark', 'klisl');
              $result = Yii::getLogger()->getProfiling(['klisl']);  //...ЗАМЕР ПРОИЗВОДИТЕЛЬНОСТИ...
              //print_r($result); die;  //...ВЫВОД ЗАМЕРА ПРОИЗВОДИТЕЛЬНОСТИ...

              if(!empty($row_db_result)) {
                 //
                 //if($model->save()){
                    $model->trigger(Mymod::EVENT_LOGIN_USER);  //!!!...4.ВЫЗЫВАЕМ СОБЫТИЕ ПРИ ОПРЕД.УСЛОВИИ
                 //}
                 //
                 //$session = Yii::$app->session;
                 $session->set('id_user', $row_db_result[0]['id']);
                 $session->set('filter', $row_db_result[0]['id']);
                 //$modelbase->baseapi=$modelbase->tobasemod(50);     //...РАСШИРЕНИЕ МОДЕЛИ...ИЛИ Dependency Injection Container - НИЖЕ...
                 $modelbase->baseapi=$basemod->baseapi(50);           //...Dependency Injection Container - НИЖЕ...
                 //return $this->renderPartial('ready', ['model'=>$model, 'row_db_result'=>$row_db_result, 'modelbase'=>$modelbase]);
                 //return $this->render('ready', ['model'=>$model, 'row_db_result'=>$row_db_result, 'modelbase'=>$modelbase, 'order_title'=>$row_db_result['order_title']]);
                 return $this->render('ready', ['model'=>$model, 'row_db_result'=>$row_db_result, 'modelbase'=>$modelbase, 'order_title'=>$order_title]);
              }
              else {
                 //return $this->renderPartial('index', ['model' => $model, 'errors_autentificate' => 'Mistake in login/password!']);
                 //
                 $model->trigger(Mymod::EVENT_NOT_LOGIN_USER);
                 //
                 return $this->render('index', ['model' => $model, 'errors_autentificate' => 'Mistake in login/password!']);
                 //return $this->redirect('http://25one.com.ua'); //...redirect - ЭТО location, $model-НО НЕЛЬЗЯ МАССИВ
              }
           }
           else {
              $errors = $model->errors;
              //return $this->renderPartial('index', ['model' => $model, 'errors_validate' => $errors]);
              return $this->render('index', ['model' => $model, 'errors_validate' => $errors]);
           }
        }
        else {
           //return $this->renderPartial('index', ['model' => $model]);
           $session->set('filter', 'start');
           //...cookies...
           if (!isset(\Yii::$app->request->cookies['language'])) {
               \Yii::$app->response->cookies->add(new \yii\web\Cookie([
               'name' => 'language',
               'value' => 'en',
               //'domain' => '.test.dev',
               //'expire' => time() + 180,
               ]));
           }
           else {
               $model->language=\Yii::$app->request->cookies['language'];
           }
           /*
           // удаление куки...
           $cookies->remove('language');
           // ...что эквивалентно следующему:
           unset($cookies['language']);
           */
           //...cookies...

           //...behaviors...
           $model->prop='from behaviors start';
           $prop_behaviors=$model->prop;
           //echo $model->prop; //die;
           //...behaviors...

           return $this->render('index', ['model' => $model, 'prop_behaviors' => $prop_behaviors]);
        }

    }

    public function actionPageajaxmethod()
	{

      $model=new Mymod;

      $login=$_GET['who'];
      $password=$_GET['why'];
      $string_sql='select * from mymod where login=:login and password=:password';
      $params = ['login' => $login, 'password' => $password];
      $row_db_result=$model->connectionDB($string_sql, $params);
      echo $row_db_result[0]['login'].' - '.$row_db_result[0]['password'];

    }

    public function actionHello()    //...!!!СТАТИЧЕСКАЯ СТРАНИЦА - БЕЗ ПАРАМЕТРОВ ИЗ КОНТРОЛЛЕРА...
    {
       return $this->render('hello');
    }

    public function actions()        //...!!!"МНОГО" СТАТИЧЕСКИХ СТРАНИЦ В ОДНОМ МЕСТЕ - В mymod/page...
    {
        return [
            'page' => [
                'class' => 'yii\web\ViewAction',
            ],
        ];
    }

    public function actionRequestpage()
    {
        $request = \Yii::$app->request;
        $session = \Yii::$app->session;
        $session->set('hello', 'yes');
        //$session->set('hello', 'no');  //...!!!ИММИТАЦИЯ ПЕРЕХОДА НА !СВОЮ СТРАНИЦУ ОШИБКИ ЧЕРЕЗ SiteController.php...
        $model=new Mymodrequest;
        //print_r($model->requestExample()); echo '<br>';
        $model->requestexample=$model->requestExample();
        //if(isset($_GET['requestajax'])) {
        if($request->get('requestajax')) {   //...В js НУЖНО requestajax=true, А НЕ ПРОСТО requestajax
           //return $model->requestexample;
           return json_encode($model->requestexample);
        }
        else {
           return $this->render('requestpage', ['model' => $model]);
        }

        //print_r($model->requestexample); //...ТИПА ДЛЯ json...(НО, ЗАЧЕМ...)

    }

/* ajax - ТУТ НЕ РАБОТАЕТ - НУЖНА ПЕРЕЗАГРУЗКА...
    public function actionAjaxdownload()
    {

       $request = \Yii::$app->request;
       //return \Yii::$app->response->sendFile($request->get('filename'));
       //return $request->get('filename');
       //Yii::getAlias('@webroot/uploads/' . $image->src)
       //return \Yii::$app->response->sendFile(\Yii::getAlias('@webroot/'.$request->get('filename')));
       if(file_exists(\Yii::getAlias('@webroot/'.$request->get('filename')))){
          //return \Yii::getAlias('@webroot/'.$request->get('filename'));
          //return \Yii::$app->response->sendFile(\Yii::getAlias('@webroot/'.$request->get('filename')));
          //return \Yii::$app->response->sendFile(\Yii::getAlias('@webroot/'.$request->get('filename'), [
          //'mimeType' => 'image/jpg',
          //'inline' => true,
          //]));
          return \Yii::$app->response->sendFile(\Yii::getAlias('@webroot/'.$request->get('filename')));
       }
       else {
          return "This file isn't in...";
       }
    }
*/

    public function actionFiledownload()
    {

       $model=new Mymod;

       $request = \Yii::$app->request;
       if(file_exists(\Yii::getAlias('@webroot/'.$request->get('filename')))){
          \Yii::$app->response->sendFile(\Yii::getAlias('@webroot/'.$request->get('filename')));
       }
       else {
          $model->error_download="This file isn't in...";
          return $this->render('index', ['model' => $model]);
       }
    }

/*
    public function actionRequestpostajax()
    {
        //if($request->post('guest')) {
        //    echo $request->post('guest');
        //}

        $request = \Yii::$app->request;

        if($request->get('guest')) {
            echo $request->get('guest');
        }
        //return $this->render('requestpage', ['model' => $model]);

    }
*/

}
