<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
//use app\models\Basemod;   //...ЭТО НЕ НУЖНО - Т.К.ЕСТЬ class Mymodbase extends Basemod...
use yii\base\Event;
//use yii\db\AfterSaveEvent;
use app\components\MyBehavior; //!!!...behaviors...

use yii\db\Query; //...Builder - АЛЬТЕРНАТИВА createCommand... - ДЛЯ, НАПРИМЕР, ПАКЕТНОЙ ВЫБОРКИ(batch() ВМЕСТО all() - ПО 100 ПО УМОЛЧ. - МОЖНО ИЗМЕНИТЬ)...

use yii\db\ActiveQuery;

    //...Объявление связей Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...
    class Mymodorder extends ActiveRecord   //...!!!Mymodorder - ТАБЛИЦА НАЗЫВАЕТСЯ...
    {
        public function getMymod()
        {
            return $this->hasOne(Mymod::className(), ['id' => 'user_id']); //...!!!Mymod - ТАБЛИЦА НАЗЫВАЕТСЯ, id => user_id - СВЯЗЬ...
        }
    }
    //...Объявление связей Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...

class CommentQuery extends ActiveQuery
{
    public function active($login, $password)
    {
        //return $this->andWhere(['login' => $login, 'password' => $password]);
        return $this->where(['login' => $login, 'password' => $password]);
        //...
    }
}

//class Mymod extends Models //!!!...ЕСЛИ БЕЗ ПРИВЯЗКИ К КОКРЕТНОЙ ТАБЛИЦЕ...
class Mymod extends ActiveRecord
{

    //public $login;     //!?...ЭТО ЕСЛИ НЕ ActiveRecord
    //public $password;  //!?...ЭТО ЕСЛИ НЕ ActiveRecord

    public $title='Login of Citadel';
    public $from_date;
    public $error_download;
    public $language, $prop_behaviors;
    public $ordersCount;

    const EVENT_LOGIN_USER='login_user'; //!!!...1.ОПРЕДЕЛЯЕМ СОБЫТИЕ (const, ОСТАЛЬНОЕ ПРОИЗВОЛЬНО)...
    const EVENT_NOT_LOGIN_USER='not_login_user';

    //!!!!!...ВОТ ОЧЕНЬ ИНТЕРЕСНО - ПЕРЕОПРЕДЕЛИТЬ find (В МОДЕЛИ) + ВМЕСТО where ТУТ СДЕЛАТЬ ТАМ (РАСШИРЕНИЕ ЗАПРОСОВ...)...
    public static function find()  //...!!!static
    {
         //print_r(get_called_class()); die;
         return new CommentQuery(get_called_class());  //...get_called_class() - позднее статическое связывание - app\models\Mymod -
    }                                                  //...возвращает имя класса, из которого был вызван статический метод.
    //!!!!!...ВОТ ОЧЕНЬ ИНТЕРЕСНО - ПЕРЕОПРЕДЕЛИТЬ find (В МОДЕЛИ) + ВМЕСТО where ТУТ СДЕЛАТЬ ТАМ (РАСШИРЕНИЕ ЗАПРОСОВ...)...

    //...Объявление связей Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...
    public function getOrders()
    {
        return $this->hasMany(Mymodorder::className(), ['user_id' => 'id']); //...!!!Mymodorder - ТАБЛИЦА НАЗЫВАЕТСЯ, user_id => id - СВЯЗЬ...
    }
    //...Объявление связей Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...

    public function createLetterUser($event){  //!!!...2a.ПИШЕМ МЕТОД-ОБРАБОТЧИК-createLetterUser СОБЫТИЯ ($event - ОБЯЗАТЕЛЬНО)...
       echo '<b>event:</b> create the letter for user<br>';
       // you code
       //die;
    }

    public function sendLetterUser($event){  //!!!...2b.ПИШЕМ МЕТОД-ОБРАБОТЧИК-sendLetterUser СОБЫТИЯ ($event - ОБЯЗАТЕЛЬНО)...
       echo '<b>event:</b> send the letter to user<br>';
       // you code
    }

    public function behaviorNotLogin($event){  //!!!...2c.ПИШЕМ МЕТОД-ОБРАБОТЧИК-sendLetterUser СОБЫТИЯ ($event - ОБЯЗАТЕЛЬНО)...
       echo '<b>event:</b> behavior for not login<br>';
       // you code
    }

    public function init(){                  //!!!...3.ПРИВЯЗЫВАЕМ (ТУТ В init - ХОТЯ, МОЖНО И В __construct)
                                             //!!!...4.ВЫЗЫВАЕМ СОБЫТИЕ ПРИ ОПРЕД.УСЛОВИИ - !!!В conroller
      $this->on(self::EVENT_LOGIN_USER, [$this, 'createLetterUser']);
      $this->on(self::EVENT_LOGIN_USER, [$this, 'sendLetterUser']);
      $this->on(self::EVENT_NOT_LOGIN_USER, [$this, 'behaviorNotLogin']);
      //...И Т.Д. - ВСЕ, ЧТО НУЖНО ПРИ УДАЧНОМ ВХОДЕ ПОЛЬЗОВАТЕЛЯ...

      // first parameter is the name of the event and second is the handler.
      // For handlers I use methods sendMail and notification
      // from $this class.
    }

    /*
    public function __construct()
    {
      $this->on(self::EVENT_LOGIN_USER, [$this, 'createLetterUser']);
      $this->on(self::EVENT_LOGIN_USER, [$this, 'sendLetterUser']);

      // first parameter is the name of the event and second is the handler.
      // For handlers I use methods sendMail and notification
      // from $this class.
    }
    */

    public function behaviors()
    {
        return [
            // анонимное поведение, прикрепленное по имени класса
            MyBehavior::className(),

            /*
            // именованное поведение, прикрепленное по имени класса
            'myBehavior2' => MyBehavior::className(),

            // анонимное поведение, сконфигурированное с использованием массива
            [
                'class' => MyBehavior::className(),
                'prop1' => 'value1',
                'prop2' => 'value2',
            ],
            */

        ];
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/iu'],
            [['login', 'password', 'from_date'], 'required'],
            //[['login'], 'required'],  //!!!...ТОЛЬКО ЭТО НЕЛЬЗЯ - НЕ БУДЕТ РАБОАТЬ "МАССОВОЕ ПРИСВАИВАНИЕ" $model->attributes = \Yii::$app->request->post('Mymod');
            [['password_value'], 'safe'], //!!!...ИЛИ ТАК - БЕЗ ФАКТИЧЕСКОЙ ВАЛИДАЦИИ, НО БУДЕТ РАБОАТЬ "МАССОВОЕ ПРИСВАИВАНИЕ"...
            //['email', 'email'],
        ];
    }

    public function fields()    //...?ПЕРЕОПРЕДЕЛЕНИЕ ПОЛЕЙ, ЕСЛИ ЧТО...
    {
        /*
        return [
            // здесь имя поля совпадает с именем атрибута
            'login',

            // здесь имя поля - "email", соответствующее ему имя атрибута - "email_address"
            //'password' => 'password_value',
        ];
        */

        $fields = parent::fields();

        // удаляем поля, содержащие конфиденциальную информацию
        unset($fields['password']); //...ЭТО ДЛЯ $model->toArray(), НО НЕ ДЛЯ $model->attributes...

        return $fields;
    }

    public function connectionDB($string_sql, $params)  //$params = [':id' => $_GET['id'], ':status' => 1];
	{

       //Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_FIND, function ($event) {
       //   //Yii::debug(get_class($event->sender) . ' искали');
       //   echo get_class($event->sender) . ' искали<br>';
       //});

        $connection=\Yii::$app->db;  //!!!...ДЛЯ ВОЗМОЖНОСТИ ПРОСТО ПИСАТЬ ЗАПРОСЫ "РУКАМИ"(ЧТО ЧАСТО УДОБНЕЕ)...

        /*
        $row_db=$connection->createCommand('select * from {{mymod}} where [[login]]=:login and [[password]]=:password')
           //->bindValue(':login', $login)   //...ИЛИ, НАПРИМЕР, ВМЕСТО $login $_GET['login'], НО...
           //->bindValue(':password', $password)  //...НАПРЯМУЮ В ЗАПРОС !!!НЕЛЬЗЯ - SQL-ИНЪЕКЦИЯ!!!!!...
           ->bindValues($params)
           ->queryAll();
           //->queryOne();
        //print_r($row_db); die;
        */

        //...Builder - АЛЬТЕРНАТИВА createCommand... - ДЛЯ, НАПРИМЕР, ПАКЕТНОЙ ВЫБОРКИ(batch() ВМЕСТО all() - ПО 100 ПО УМОЛЧ. - МОЖНО ИЗМЕНИТЬ)...
        //$login = Yii::$app->request->get('login');   //...ТУТ ЗАЩИТА ЕСТЬ - get(...
        //$password = Yii::$app->request->get('password'); //...ТУТ ЗАЩИТА ЕСТЬ - get(...
        $login = Yii::$app->request->post('Mymod')['login'];       //...ТУТ ЗАЩИТА ЕСТЬ - post(... - !!!post('Mymod')['login']
        $password = Yii::$app->request->post('Mymod')['password']; //...ТУТ ЗАЩИТА ЕСТЬ - get(...
        //print_r($login); echo '<br>';
        //print_r($password); echo '<br>';
        $row_db = (new Query())
             //->select(['id', 'email'])  //...ОТСУТСТВИЕ РАВНОСИЛЬНО select * ...
             ->from('mymod')
             ->where(['login' => $login, 'password' => $password])
             //->one();
             ->all();

             //print_r($row_db); die;

              //...СВЯЗИ Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...
              // SELECT * FROM `mymod` WHERE `id` = $row_db_result[0]['id']
              //$user = $model->findOne(1);
              $user = $this->findOne($row_db[0]['id']);
              // SELECT * FROM `mymodorder` WHERE `user_id` = $row_db_result[0]['id']
              // $orders - это массив объектов Order
              $orders = $user->orders;
              foreach ($orders as $k=>$order) {
                 //print_r($order->attributes); echo '<br>';
                 $order_title[]=$order->attributes['order'];
              }
              //print_r($order_title); echo '<br>';
              //die;

              $row_db['order_title']=$order_title;

              //...СВЯЗИ Active Record - НОВАЯ ТАБЛИЦА mymodorder (?!ТИПА join)...

/*
        $query = (new Query())
             //->select(['id', 'email'])  //...ОТСУТСТВИЕ РАВНОСИЛЬНО select * ...
             ->from('mymod')
             ->where(['login' => $login, 'password' => $password]);
             //->one();
             //->all();

             //print_r($row_db); die;

             foreach ($query->batch() as $row_db) { //...ПАКЕТНАЯ ПО [batchSize] => 100
                //print_r($row_db); echo '<br>';
             }
             //die;
*/

             //print_r($row_db); die;

             return $row_db;

	}

}

class Mymodbase extends Basemod       //...РАСШИРЕНИЕ МОДЕЛИ...
{

    public function tobasemod($money)
	{
        $basemodel=new Basemod;
        return $basemodel->baseapi($money);

	}

}
