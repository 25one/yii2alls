<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

//Yii::$classMap['yii\helpers\MyHelper'] = '@app/components/MyHelper.php'; //...!!!ÌÎÉ ÊÎÌÏÎÍÅÍÒ... - ÈËÈ Â componets - !!!À ÏÎ ÑÓÒÈ - È ÍÅ ÍÓÆÍÎ - È ÒÀÊ ÌÎÆÍÎ use È ÂÛÇÂÀÒÜ...

//Yii::$classMap['yii\helpers\ArrayHelper'] = __DIR__ . '/../components/ArrayHelper.php';  //...ÌÎÆÍÎ ÏÅĞÅÎÏĞÅÄÅËÈÒÜ È ÈÕ ÌÅÒÎÄ, ÅÑËÈ ÍÓÆÍÎ...

//$config = require __DIR__ . '/../config/web.php';

// ñëèâàåì ìíîãîìåğíûå ìàññèâû
$config = \yii\helpers\ArrayHelper::merge(
	//require __DIR__ . '/../config/defaults.php', // ìíîãîìåğíûé ìàññèâ íàñòğîåê ïî óìîë÷àíèş
	require __DIR__ . '/../config/web.php', // ìíîãîìåğíûé ìàññèâ íàñòğîåê âåá îêğóæåíèÿ
	require __DIR__ . '/../common/config/main.php' // ...translate for languages
);

(new yii\web\Application($config))->run();
