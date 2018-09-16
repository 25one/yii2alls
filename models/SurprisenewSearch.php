<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Connection;

class SurprisenewSearch extends Surprisenew
{

    public function rules()
    {

        return [

            //[['name'], 'safe'],
            //[['name', 'id'], 'safe'],
            [['name', 'id'], 'safe'],

        ];
    }

    public static function tableName() {
       return '{{%surprisenew}}';
    }

    public function search($params)
    {

        $session = Yii::$app->session;

        $query = Surprisenew::find()
        ->select(['mylogin.username', 'surprisenew.id', 'surprisenew.name', 'limit_for_all', 'limit_for_one', 'status'])
        ->from('surprisenew')
        ->innerJoin('mylogin', '`mylogin`.`id` = `surprisenew`.`id_user`')
        ->where(['mylogin.id' => $session->get('id_user')])->cache(60);  //...!!!ÒÀÊ ÏÐÎÙÅ...
        //->where(['mylogin.id' => $session->get('id_user')]);

        //
        if($session->hasFlash('id_add_item')) {
           $sort_coll='id';
           $sort_way=SORT_DESC;
        }
        else {
           $sort_coll='name';
           $sort_way=SORT_ASC;
        }
        //

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                'pagination' => [
                    'pageSize' => 5,
                ],
                'sort' => [
                    'defaultOrder' => [
                        //'name' => SORT_ASC,
                        $sort_coll => $sort_way,
                    ],
                 ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'surprisenew.name', $this->name]);
        $query->andFilterWhere(['>', 'surprisenew.id', $this->id]);

        return $dataProvider;

    }
}

