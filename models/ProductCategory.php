<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ProductCategory extends ActiveRecord
{

    public $product_category;

    public function rules()
    {

        return [
           ['product_category', 'safe'],
        ];

    }

}
