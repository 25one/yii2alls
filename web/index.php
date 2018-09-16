<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

//Yii::$classMap['yii\helpers\MyHelper'] = '@app/components/MyHelper.php'; //...!!!��� ���������... - ��� � componets - !!!� �� ���� - � �� ����� - � ��� ����� use � �������...

//Yii::$classMap['yii\helpers\ArrayHelper'] = __DIR__ . '/../components/ArrayHelper.php';  //...����� �������������� � �� �����, ���� �����...

//$config = require __DIR__ . '/../config/web.php';

// ������� ����������� �������
$config = \yii\helpers\ArrayHelper::merge(
	//require __DIR__ . '/../config/defaults.php', // ����������� ������ �������� �� ���������
	require __DIR__ . '/../config/web.php', // ����������� ������ �������� ��� ���������
	require __DIR__ . '/../common/config/main.php' // ...translate for languages
);

(new yii\web\Application($config))->run();
