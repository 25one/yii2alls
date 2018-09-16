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
        //'code', //...��� �� �� ����
        // �������� ���� ��������� � ������ ��������
        'name',
        // �������� ���� "email", ������� "email_address"
        'country_population' => 'population',
        // �������� ���� "name", �������� ������������ callback-�� PHP
        'name_and_population' => function () {
            return $this->name . ' - ' . $this->population;
        },
    ];
}

/*
// ����������� ��������� ����. ����� ����� ������������ � ������ ������������
public function fields()
{
    $fields = parent::fields();

    // ������� ������������ ����
    unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

    return $fields;
}
*/

}
