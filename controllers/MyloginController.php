<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Mylogin;
use app\models\ProductCategory;
use app\models\Surprisenew;
use app\models\SurprisenewSearch;
use app\models\Country;
use app\models\MailerForm;
use app\models\WriteJob;
use yii\data\ActiveDataProvider;
use app\components\MyHelper;

class MyloginController extends Controller
{

    public $layout = 'basemylogin';
    //public $htmlLayout = 'layouts/html';

    public function behaviors()
    {
        return [
            /*
            'cache_server' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60,
                //'variations' => [
                //    \Yii::$app->language,
                //],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'SELECT COUNT(*) FROM mylogin',
                ],
            ],
            */

            //...йеьхпнбюмхе оепбни ярпюмхжш - сфе леьюер опх пюанре я яеяяхълх я оепбни мю нярюкэмше...
            /*
            'cache_client' => [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index'],
                'lastModified' => function ($action, $params) {
                   $q = new \yii\db\Query();
                   return $q->from('mylogin')->count();
                },
            ],
            */

        ];
    }

    public function actionIndex()
    {

       $model=new Mylogin;
       $model_=new ProductCategory;

       if(\Yii::$app->request->get()['language']) {
           \Yii::$app->language = \Yii::$app->request->get()['language'];
       }
       else {
          \Yii::$app->language = 'en';
       }
       \Yii::$app->session->set('language', \Yii::$app->language);

       $helper = new MyHelper;

       //print_r(MyHelper::something('Hello', 'mr.Alex...'));

       return $this->render('index', ['model' => $model, 'model_' => $model_]);

    }

    /*
    public function actionSelectLanguage()
    {

       $model=new Mylogin;
       $model_=new ProductCategory;

       \Yii::$app->language=\Yii::$app->request->get()['language'];

       return $this->render('index', ['model' => $model, 'model_' => $model_]);

    }
    */

    public function actionMailer()
    {

        if(\Yii::$app->request->get()['language']) {
           \Yii::$app->language=\Yii::$app->request->get()['language'];
        }
        else {
           \Yii::$app->language=\Yii::$app->session->get('language');
         }
        \Yii::$app->session->set('language', \Yii::$app->language);

        $model = new MailerForm();

        //...лскэрх-нропюбйю...
        //$model_ = new Mylogin;
        //$mails = $model_->find()->select(['[[email]]'])->asArray()->all();

        if ($model->load(\Yii::$app->request->post()) && $model->sendEmail()) {
        //if ($model->load(\Yii::$app->request->post()) && $model->sendEmail($mails)) {  //...лскэрх-нропюбйю...
            \Yii::$app->session->setFlash('mailerFormSubmitted');
            return $this->refresh();
        }
          return $this->render('mailer', [
              'model' => $model,
          ]);
    }

    public function actionAjaxspecialvalidation($login=null, $pass=null, $category=null, $language=null)
    {

    $model=new Mylogin;

    if(!$model->Ajaxspecialvalidation($login, $pass)) {

    $session = Yii::$app->session;

    $session->set('language', $language);

    $row_db_result = (new \yii\db\Query())
        ->select(['[[mylogin.id]]', '[[mylogin.password]]', '[[mylogin.username]]', '[[mylogin.image]]'])
        ->from('{{mylogin}}')
        ->join('left join', '{{product_category}}', '[[product_category.id_user]]=[[mylogin.id]]')
        //->where('[[mylogin.username]]=:username and [[mylogin.password]]=:password    //...щрн ашкн аег hash password - ме бепмн...
        ->where('[[mylogin.username]]=:username
                 and [[product_category.id]]=:product_category')
        ->addParams([':username' => $login,
                      //':password' => $pass, //...щрн ашкн аег hash password - ме бепмн...
                      ':product_category' => $category])
        //->where('[[mylogin.username]]=:username and [[product_category.id]]=:product_category',
        //        [':username' => $login, ':product_category' => $category])     //...!!!хкх рюй...
        ->all();
        //->cache(60)->all();

    //...еякх DAO (!мюопхлеп, ондгюопняш...(ю, лнфер, х join)) - insert-опхлеп мхфе... :
    /*
    $userIDs = $connection
    ->createCommand('SELECT id FROM user where status=:status')
    ->bindValues([':status' => $status])  //...!!!bindValues([':status' => $status])
    ->queryColumn();  //...!!!queryColumn()
    */

     //if($row_db_result) {  //...щрн ашкн аег hash password - ме бепмн...
     if($row_db_result && Yii::$app->getSecurity()->validatePassword($pass, $row_db_result[0]['password'])) { //...щрн бепмн - я hash password...
        $session->set('id_user', $row_db_result[0]['id']);
        $session->set('name_user', $row_db_result[0]['username']);
        $session->set('image_user', $row_db_result[0]['image']);

        //...рср hash дкъ update - бннаые опх insert мнбнцн user...
            /*
            $hash_pass = Yii::$app->getSecurity()->generatePasswordHash($pass);
            $command=Yii::$app->db->createCommand("update mylogin set
            password=:password
            where id=:id");
            $command->bindParam(":password", trim($hash_pass));
            $command->bindParam(":id", $row_db_result[0]['id']);
            $command->execute();
            */
        //...рср hash дкъ update - бннаые опх insert мнбнцн user...

        return $this->redirect('login');

     }
     else {
        return 'Access error...';
     }

     }
     else {
        return $model->Ajaxspecialvalidation($name, $email);
     }

    }

    public function actionLogin()
    {

       $model_surprise=new Surprisenew;
       $model_country=new Country;
       $model_queue=new WriteJob;     //...queue
       $session = Yii::$app->session;

       if(\Yii::$app->request->get()['language']) {
          \Yii::$app->language=\Yii::$app->request->get()['language'];
       }
       else {
          \Yii::$app->language=$session->get('language');
       }
       \Yii::$app->session->set('language', \Yii::$app->language);


       //нРОПЮБЙЮ ГЮДЮМХЪ Б НВЕПЕДЭ

       $id = Yii::$app->queue->push(new WriteJob([   //...?рюл йнмярпсйрнп - онщрнлс аег янгдюмхъ назейрю ябепус...
           'text' => 'test_new',
           'file' => Yii::$app->basePath . '/web/file.txt'
       ]));
       /*
       //...х рср фе run-нвепедх - хллхрюжхъ Watcer-пю мю cron... - !!!???хмрепеямши лнлемр...
       //Yii::$app->queue->run();
       //...х рср фе run-нвепедх - хллхрюжхъ Watcer-пю мю cron... - !!!???хмрепеямши лнлемр...
       */
       //...

       if($model_surprise->load(\Yii::$app->request->post())) {
          if ($model_surprise->validate()) {

            /*
            $name = Yii::$app->request->post('Surprisenew')['name'];
            $limit_for_all = Yii::$app->request->post('Surprisenew')['limit_for_all'];
            $limit_for_one = Yii::$app->request->post('Surprisenew')['limit_for_one'];
            $status = Yii::$app->request->post('Surprisenew')['status'];
             Yii::$app->db->createCommand()->insert('{{surprisenew}}', [
             '[[name]]' => $name,
             '[[limit_for_all]]' => $limit_for_all,
             '[[limit_for_one]]' => $limit_for_one,
             '[[status]]' => $status,
             '[[id_user]]' => $session->get('id_user'),
             ])->execute();
             */
             //...ксвье ActiveRecord - хмюве ме пюанрюер янашрх EVENT_AFTER_INSERT дкъ нвхярйх йеью(behaviors)...
             $model_surprise->name = Yii::$app->request->post('Surprisenew')['name'];
             $model_surprise->limit_for_all = Yii::$app->request->post('Surprisenew')['limit_for_all'];
             $model_surprise->limit_for_one = Yii::$app->request->post('Surprisenew')['limit_for_one'];
             $model_surprise->status = Yii::$app->request->post('Surprisenew')['status'];
             $model_surprise->id_user = $session->get('id_user');
             //$model_surprise->save();
             $model_surprise->insert();
             //
             $id_add_item=$model_surprise->find()->max('id');
             $session->setFlash('id_add_item', $id_add_item);
             //print_r($id_add_item); die;
             //
          }
       }

       if($session->get('id_user')==1) {

           $searchModel_surprise = new SurprisenewSearch();
           $provider_surprise = $searchModel_surprise->search(Yii::$app->request->get());

           $provider_surprise->pagination->pageParam = 'surprise-page';
           $provider_surprise->sort->sortParam = 'surprise-sort';


       }


       $provider_country = new ActiveDataProvider([
            'query' => $model_country->find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ],
             ],
       ]);

       $provider_country->pagination->pageParam = 'country-page';
       $provider_country->sort->sortParam = 'country-sort';

       return $this->render('login', ['model_surprise' => $model_surprise, 'provider_surprise' => $provider_surprise, 'searchModel_surprise' => $searchModel_surprise, 'provider_country' => $provider_country]);

    }

    public function actionSurprisenewLeadDelete($id)
    {

       $model=new Surprisenew;

       $model->findOne($id)->delete();

       //return $this->redirect('login');  //...ашкн, йнцдю ашкн <action:[-\w]+>' => 'mylogin/<action>',(ме дкъ RESTful API)
       return $this->redirect('/login');

    }

    public function actionSurprisenewLeadUpdateSelect($model_name, $id)
    {

       $model=new Surprisenew;
       $row_db_result = $model->find()->where(['id' => $id])
                              ->asArray()->all();
       return json_encode($row_db_result);

    }

    public function actionSurprisenewLeadUpdateSave($id, $name, $limit_for_all, $limit_for_one, $status)
    {

       $model=new Surprisenew;
       $session = Yii::$app->session;      

       if(!$model->Ajaxspecialvalidation($name, $limit_for_all, $limit_for_one, $status)) {
            /*
            $command=Yii::$app->db->createCommand("update surprisenew set
            name=:name, limit_for_all=:limit_for_all, limit_for_one=:limit_for_one, status=:status
            where id=:id");
            $command->bindParam(":id", $id);
            $command->bindParam(":name", $name);
            $command->bindParam(":limit_for_all", $limit_for_all);
            $command->bindParam(":limit_for_one", $limit_for_one);
            $command->bindParam(":status", $status);
            //...хкх рюй...
            //$command->bindValues([':id' => $id, ':name' => $name, ':limit_for_all' => $limit_for_all, ':limit_for_one' => $limit_for_one, ':status' => $status]);
            //
            $command->execute();
            */

            //...ксвье ActiveRecord - хмюве ме пюанрюер янашрх EVENT_AFTER_UPDATE дкъ нвхярйх йеью(behaviors)...
            $updating = $model->findOne($id);
            $updating->name = $name;
            $updating->limit_for_all = $limit_for_all;
            $updating->limit_for_one = $limit_for_one;
            $updating->status = $status;
            //$updating->save();
            $updating->update();
            //
            //$id_add_item=$model_surprise->find()->max('id');
            $session->setFlash('id_update_item', $id);
            //print_r($id_add_item); die;
            //

            //return $this->redirect('login');  //...рюй хлеммн рср (дкъ ajax - гюйпшрхъ нймю) ме онидер...

       }
       else {
          return $model->Ajaxspecialvalidation($name, $limit_for_all, $limit_for_one, $status);
       }

    }

}
