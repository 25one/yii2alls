<?php

return [

    //'language' => 'ru-RU', // ...
    //'language' => 'en-US', // ...
    'language' => 'en', // ...

    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/common/messages',
                    //'sourceLanguage' => 'ru-RU',
                    //'sourceLanguage' => 'en-US',
                    'sourceLanguage' => 'en',
                     'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],

];