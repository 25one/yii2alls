<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
//$db['dsn'] = 'mysql:host=localhost;dbname=yii2_basic_tests';
$db['dsn'] = 'mysql:host=ag248566.mysql.ukraine.com.ua;dbname=ag248566_casexe';
$db['username'] = 'ag248566_casexe';
$db['password'] = 'm8gyxcyu';
$db['charset'] = 'utf8';

return $db;
