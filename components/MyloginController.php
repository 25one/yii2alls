<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Mylogin;
use app\models\ProductCategory;
use app\models\Modbase;
use yii\widgets\ActiveForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\Country;
use yii\data\ActiveDataProvider;
//use yii\data\SqlDataProvider;
use app\components\MyDataProvider;

class MyloginController extends Controller
{

    public $layout = 'basemylogin';

    public $pagination;

    public function actionIndex()
    {

       print_r($_GET); echo ' - GET<br>';
       print_r($_POST); echo ' - POST<br>';  //...$_POST['Mylogin']['username'], $_POST['Mylogin']['password'], $_POST['Mylogin']['who'][1] (a or b)...

       //...Специальная валидация - НЕ СВЯЗАННЫХ С МОДЕЛЬЮ ЗНАЧЕНИЙ - ВЫЗОВ НЕОБХОДИМОГО ВАЛИДАТОРА НАПРЯМУЮ...
       //$email = 'test@example.com';
       $email = '@example.com';
       $validator = new \yii\validators\EmailValidator();

       if ($validator->validate($email, $error)) {
           echo 'Email is valid.<br>';
       } else {
           echo $error.'<br>';
       }
       //...Специальная валидация - НЕ СВЯЗАННЫХ С МОДЕЛЬЮ ЗНАЧЕНИЙ - ВЫЗОВ НЕОБХОДИМОГО ВАЛИДАТОРА НАПРЯМУЮ...

       $model=new Mylogin;
       $model_=new ProductCategory;
       $model_base=new Modbase;     //...!!!"БАЗОВАЯ" МОДЕЛЬ - ОБЩИЕ ДЛЯ ВСЕХ МЕТОДЫ (БД, НАПРИМЕР...)...
       //$model_=new UploadForm;

       //print_r($model);

       //if($model->load(\Yii::$app->request->post()) && !\Yii::$app->request->isAjax) { //!!!...ПРОВЕРКА НАЖАТИЯ КНОПКИ...(ТУТ БЕЗ 'Mylogin')) + !!!ЗАПОЛНЕНИЕ МОДЕЛИ ПОЛЬЗОВАТЕЛЬСКИМИ ДАННЫМИ ИЗ ФОРМЫ - ТОГДА НЕ НУЖНО $model->attributes =...
       if($model->load(\Yii::$app->request->post()) && $model_->load(\Yii::$app->request->post())) {
       //if(\Yii::$app->request->post('Mylogin')['username']) { //!!!...ИЛИ ТАК...!!!НО ТУТ НЕТ ЗАПОЛНЕНИЕ МОДЕЛИ - ТОГДА НУЖНО $model->attributes =...
          //print_r(\Yii::$app->request->post()); die;
          //$model->attributes = \Yii::$app->request->post('Mylogin'); //!!!...ЭТО, КСТАТИ, ЗАПОЛНЕНИЕ МОДЕЛИ ПОЛЬЗОВАТЕЛЬСКИМИ ДАННЫМИ ИЗ ФОРМЫ...

          $model->country='USA'; //...ЕСЛИ ТАК - ТО БЕЗ $model->state - НЕ ПРОЙДЕТ when-ВАЛИДАЦИЯ...
          $model->state='NY';    //...БЕЗ ЭТОГО НЕ ПРОЙДЕТ when-ВАЛИДАЦИЯ...
          //$model->country='Germany'; //...А ЕСЛИ ТАК - ТО МОЖНО И БЕЗ $model->state - ПРОЙДЕТ when-ВАЛИДАЦИЯ...

          //...ПРОВЕРКА ВСТРОЕННУХ ВАЛИДАТОРОВ - ОШИБКИ...
          //$model->country='Spain'; //...ЕСЛИ ТАК - ТО БЕЗ $model->state - НЕ ПРОЙДЕТ when-ВАЛИДАЦИЯ...
          //$model->state='NYYYYY';    //...БЕЗ ЭТОГО НЕ ПРОЙДЕТ when-ВАЛИДАЦИЯ...
          //...ПРОВЕРКА ВСТРОЕННУХ ВАЛИДАТОРОВ - ОШИБКИ...

          //print_r($model->attributes); echo '<br>'; //die;

          //if ($model->validate() and !$model->errors['behavior']) { //...!$model->errors->serg(?!ИССКУСТВЕННО - НЕ rules) - behaviors - EVENT_BEFORE_VALIDATE...
          //if ($model->validate() and !$model->hasErrors()) {

          //if ($model->validate()) {

          $isValid = $model->validate();
          $isValid = $model_->validate() && $isValid;
          if ($isValid) {

          //if (!$model->hasErrors()) {
             // все данные корректны
             //return $this->render('login', ['model' => $model]);  //...renderPartial - without layout

            //###########################################
            //...1.ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - "РУЧНОЙ" createCommand(!!!НО С ЗАЩИТОЙ ЧЕРЕЗ bindValues)...
            //...!!! + ПРАВИЛЬНОЕ ЭКРАНИРОВАНИЕ ДЛЯ ИМЕН ТАБЛИЦ({{...}}) + ПОЛЕЙ([[...]])...
            /*
            $string_sql = "SELECT [[mylogin.id]] FROM {{mylogin}}
            left join {{product_category}} ON [[product_category.id_user]]=[[mylogin.id]]
            WHERE [[mylogin.username]]=:username and [[mylogin.password]]=:password
            and [[product_category.id]]=:product_category";
            $params = [':username' => $model->username,
                       ':password' => $model->password,
                       ':product_category' => $model_->product_category];
            $row_db_result = $model_base->connectionDB_createCommand($string_sql, $params);    //...ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - "РУЧНОЙ" createCommand(!!!НО С ЗАЩИТОЙ ЧЕРЕЗ bindValues)...
            */
            //...1.ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - "РУЧНОЙ" createCommand(!!!НО С ЗАЩИТОЙ ЧЕРЕЗ bindValues)...
            //...!!! + ПРАВИЛЬНОЕ ЭКРАНИРОВАНИЕ ДЛЯ ИМЕН ТАБЛИЦ({{...}}) + ПОЛЕЙ([[...]])...
            //###########################################
            //...2.!!!НЕ ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - ЧЕРЕЗ Builder(!!!НО С ЗАЩИТОЙ ЧЕРЕЗ Yii::$app->request->post('Mymod')['login'])...
            //...!!!???УЖЕ НЕ ТАК УДОБНО, КАК createCommand - "СБОРКА"...
            //...!!! + ПРАВИЛЬНОЕ ЭКРАНИРОВАНИЕ ДЛЯ ИМЕН ТАБЛИЦ({{...}}) + ПОЛЕЙ([[...]])...
            /*
            $username = Yii::$app->request->post('Mylogin')['username'];
            $password = Yii::$app->request->post('Mylogin')['password'];
            $product_category = Yii::$app->request->post('ProductCategory')['product_category'];
            $row_db_result = (new \yii\db\Query())//... (new \yii\db\Query()) - БЕЗ use
                ->select(['[[mylogin.id]]'])      //...->select(['id', 'email']) - !ТУТ РЕАЛЬНЫЙ МАССИВ...
                ->from('{{mylogin}}')             //...ТУТ ПРОСТО СТРОКА...
                ->join('left join', '{{product_category}}', '[[product_category.id_user]]=[[mylogin.id]]')  //...ТУТ - ИМЕЕНО ТАКАЯ СТРУКТУРА join...
                ->where('[[mylogin.username]]=:username and [[mylogin.password]]=:password
                      and [[product_category.id]]=:product_category')        //...ТУТ ПРОСТО СТРОКА...
                ->addParams([':username' => $username,
                              ':password' => $password,
                              ':product_category' => $product_category])     //...!ТУТ РЕАЛЬНЫЙ МАССИВ...
                //->limit(10)
                ->all();
            */
            //...!!! + ПРАВИЛЬНОЕ ЭКРАНИРОВАНИЕ ДЛЯ ИМЕН ТАБЛИЦ({{...}}) + ПОЛЕЙ([[...]])...
            //...2.!!!НЕ ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - ЧЕРЕЗ Builder(!!!НО С ЗАЩИТОЙ ЧЕРЕЗ Yii::$app->request->post('Mymod')['login'])...
            //...!!!???УЖЕ НЕ ТАК УДОБНО, КАК createCommand - "СБОРКА"...
            //###########################################
            //...3.!!!НЕ ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - ЧЕРЕЗ !!!ActiveRecord - НО, СНАЧАЛА НУЖНО УСТАНОВИТЬ СВЯЗИ(СМ.Modbase)...
            //$user = $model->findOne(1);

            $username = Yii::$app->request->post('Mylogin')['username'];
            $password = Yii::$app->request->post('Mylogin')['password'];
            $product_category = Yii::$app->request->post('ProductCategory')['product_category'];
            $user = $model->findOne(['username' => $username,
                                    'password' => $password,]);
            //print_r($user); echo '<br>';
            //$category = $user->category;  //...А ГЕТТЕР(КСТАТИ) НАЗЫВАЕТСЯ getCategory()...
            //print_r($category); echo '<br>';
            $row_db_result = $user->getCategory()
                        ->where('[[product_category.id]]='.$product_category)
                        ->all();
            //print_r($row_db_result);
            //die;

            //...3.!!!НЕ ЧЕРЕЗ "БАЗОВУЮ" МОДЕЛЬ - ЧЕРЕЗ !!!ActiveRecord - НО, СНАЧАЛА НУЖНО УСТАНОВИТЬ СВЯЗИ(СМ.Modbase)...   
            //###########################################

             if($row_db_result) {
                $session = Yii::$app->session;
                //$session->set('id_user', $row_db_result[0]['login_id']);  //!!!id + view - id
                $session->set('id_user', $row_db_result[0]['id']);  //!!!id + view - id
                return $this->redirect('?r=mylogin/login');
             }
             else {
                return $this->render('index', ['model' => $model, 'model_' => $model_, 'errors' => $errors, 'error_db' => "You can't use this category..."]);
             }


          } else { //...ЭТО, ЕСЛИ НУЖНО ОСОБО(НЕ yii-СТАНДАРНО) ОБРАБОТАТЬ ОШИБКИ...
            // данные не корректны: ?$errors - массив содержащий сообщения об ошибках - !!!getErrors()
            //$errors = $model->getErrors(); //...!!!???ТИПА СТАНДАРТНЫЙ...
            $errors = $model->errors;      //...!!!??ТИПА ИССКУСТВЕННО САМ ДОБАВЛЯЮ В Behavior...
            //Html::encode($model->errors['behavior']).'<br>' - БЫЛО В index ДЛЯ ОБРАБОТКИ СОБЫТИЯ ЧЕРЕЗ behavior...
            print_r($model->errors); echo '<br>'; //die;
            print_r($model->getErrors()); echo '<br>';
            return $this->render('index', ['model' => $model, 'model_' => $model_, 'errors' => $errors]);  //...renderPartial - without layout
            //return $this->render('index', ['model' => $model]);  //...renderPartial - without layout
          }

       }
       //else if ($model->load(\Yii::$app->request->post()) && \Yii::$app->request->isAjax) {  //...ЕСЛИ НА ФОРМЕ 'enableAjaxValidation' => true
       //   \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       //   //return ActiveForm::validate($model);
       //   $user = \app\models\Status::find(1);
       //   return $user;
       //}

       /*
       //else if(\Yii::$app->request->post('UploadForm')['imageFile']) {  //...ЕСЛИ ЧТО(В ОДНОМ ДЕЙСТВИИ - ОДНА И ТА ЖЕ СТРАНИЦА index) - НЕ ТАК...
       else if($model_->load(\Yii::$app->request->post())) {              //...ТАК...
        //print_r(\Yii::$app->request->post()); die;
        //if (\Yii::$app->request->isPost) {
            $model_->imageFile = UploadedFile::getInstance($model_, 'imageFile');
            if ($model_->upload()) {
                // file is uploaded successfully
                //return;
                return $this->render('index', ['model' => $model]);
                //return $this->redirect('mylogin/index', ['model' => $model]);
                //return $this->redirect('mylogin/index');
            }
            //$model_->upload();
        //}
       }
       */

       else {

          return $this->render('index', ['model' => $model, 'model_' => $model_]);  //...renderPartial - without layout

       }

    }


    public function actionLogin()
    {

       $model=new Mylogin;

       $model_=new UploadForm;

       $model_country=new Country;

       if($model_->load(\Yii::$app->request->post())) {
            $model_->imageFiles = UploadedFile::getInstances($model_, 'imageFiles'); //...imageFiles(!в 2-х местах) + getInstances (!s) - ДЛЯ МНОЖЕСТВЕННОЙ ЗАГРУЗКИ ФАЙЛОВ...
            if ($model_->upload()) {
                // file is uploaded successfully
                //return;
                $model->upload_result='Successfull of uploading...';
                return $this->render('login', ['model' => $model]);
            }
            else {
                $model->upload_result='Error of uploading...';
                return $this->render('login', ['model' => $model]);
            }
       }
       else {

          //...СОРТИРОВКА И ПАГИНАЦИЯ ОТДЕЛЬНО...
          /*
          //...СОРТИРОВКА...
          $sort = new \yii\data\Sort([
                'attributes' => [
                    'code',
                    'name' => [
                        //'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                        'asc' => ['name' => SORT_ASC],
                        //'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                        'desc' => ['name' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'default' => SORT_ASC,
                        'label' => 'Name',
                    ],
                    'population',
                ],
          ]);
          //...СОРТИРОВКА...

          //...ПАГИНАЦИЯ...
          //$query = Country::find()->where(['status' => 1]); //...ИЛИ БЕЗ $model_country=new UploadForm; - Country::find(...
          $query = $model_country->find();
          $countQuery = clone $query;
          //$pages = new Pagination(['totalCount' => $countQuery->count()]);
          $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]); //...pageSize' => 5 - КОЛИЧЕСТВО НА СТРАНИЦЕ...
          $pages->pageSizeParam = false;
          $models = $query->offset($pages->offset)
                  ->orderBy($sort->orders)
                  ->limit($pages->limit)
                  ->all();
          //...ПАГИНАЦИЯ...

          return $this->render('login', ['model' => $model, 'models' => $models, 'pages' => $pages, 'sort' => $sort]);

          */
          //...СОРТИРОВКА И ПАГИНАЦИЯ ОТДЕЛЬНО...

          //...СОРТИРОВКА И ПАГИНАЦИЯ ВСТРОЕНЫ В DataProvider...
          $query = $model_country->find();
          $provider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 5,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'name' => SORT_ASC,
                        //'name' => SORT_DESC,
                    ],
                    'attributes' => [
                       'name' => [
                           'asc' => ['name' => SORT_ASC],
                           'desc' => ['name' => SORT_DESC],
                           'label' => 'name',
                       ],
                    ],
                ],
          ]);

          //
          $myprovider = new MyDataProvider([
                //'query' => $query,
                //'allModels' => $models,
                'pagination' => [
                    'pageSize' => 3,
                ],
          ]);
          //

          // возвращает массив объектов
          $models = $provider->getModels();

          //return $this->render('login', ['model' => $model, 'models' => $models, 'pages' => $pages, 'sort' => $sort]);
          return $this->render('login', ['model' => $model, 'models' => $models, 'provider' => $provider, 'myprovider' => $myprovider]);
          //...СОРТИРОВКА И ПАГИНАЦИЯ ВСТРОЕНЫ В DataProvider...

       }

    }

    public function actionAjaxspecialvalidation($name, $email)  //...СВОЯ (НЕ ЧЕРЕЗ function rules) ВАЛИДАЦИЯ - ОЧЕНЬ УДОБНО ДЛЯ ajax...
    {

    $model=new Mylogin;

    return $model->Ajaxspecialvalidation($name, $email);

    }

    public function actionAjaxagain()
    {
       if(\Yii::$app->request->isAjax){
          //return 'Запрос принят!';
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $status = \app\models\Status::find()->select('user')->asArray()->column(); //...["serg"]...
          return $status;
       }
    }

/*
    public function actionUpload()
    {

        $model=new Mylogin;
        $model_ = new UploadForm();

        if (\Yii::$app->request->isPost) {
            $model_->imageFile = UploadedFile::getInstance($model_, 'imageFile');
            if ($model_->upload()) {
                // file is uploaded successfully
                //return;
                return $this->render('index', ['model' => $model]);
                //return $this->redirect('mylogin/index', ['model' => $model]);
                //return $this->redirect('mylogin/index');
            }
        }

        //return $this->render('login', ['model' => $model]);
    }
*/

}
