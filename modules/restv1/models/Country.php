<?php

namespace app\modules\restv1\models;

use yii\db\ActiveRecord;

class Country extends ActiveRecord
{

public $country_population;
public $name_and_population;

/*
public function fields()
{
    return [

        'name',
        'population',

    ];
}
*/

public function fields()
{
    return [
        //'code', //...ИЛИ ТО ЖЕ НИЖЕ
        // название поля совпадает с именем атрибута
        'name',
        // название поля "email", атрибут "email_address"
        'country_population' => 'population',
        // название поля "name", значение определяется callback-ом PHP
        'name_and_population' => function () {
            return $this->name . ' - ' . $this->population;
        },
    ];
}

/*
// отбрасываем некоторые поля. Лучше всего использовать в случае наследования
public function fields()
{
    $fields = parent::fields();

    // удаляем небезопасные поля
    unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

    return $fields;
}
*/

}
