<?php

namespace app\models;

use Yii;
use yii\db\Query;       //...Builder - АЛЬТЕРНАТИВА createCommand...
use yii\db\ActiveQuery;
use app\models\Mylogin;
use app\models\ProductCategory;

class Modbase extends \yii\base\Model
{

    //public ...;

    //...createCommand...
    public function connectionDB_createCommand($string_sql, $params)  //$params = [':id' => $_GET['id'], ':status' => 1];
	{

        $connection=\Yii::$app->db;  //!!!...ДЛЯ ВОЗМОЖНОСТИ ПРОСТО ПИСАТЬ ЗАПРОСЫ "РУКАМИ"(ЧТО ЧАСТО УДОБНЕЕ)...

        //$row_db=$connection->createCommand('select * from {{mymod}} where [[login]]=:login and [[password]]=:password')
        $row_db=$connection->createCommand($string_sql)
           //->bindValue(':login', $login)   //...ИЛИ, НАПРИМЕР, ВМЕСТО $login $_GET['login']...
           //->bindValue(':password', $password)  //...НАПРЯМУЮ В ЗАПРОС !!!НЕЛЬЗЯ - SQL-ИНЪЕКЦИЯ!!!!!...
           ->bindValues($params)
           ->queryAll();
           //->queryOne();
        //print_r($row_db); die;

        return $row_db;

    }
    //...createCommand...

    ///...!!!???ОСТАЛЬНОЕ(Builder + Activerecord) - МОЖНО(???!!!НУЖНО) И В КОНТРОЛЛЕРЕ...

}
