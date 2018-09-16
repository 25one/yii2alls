<b>1.В каталоге, доступном из web (var/www или ваш вариант настройки), выполните следующие команды:</b>
<br>git clone https://github.com/25one/yii2alls.git .(!ОБРАТИТЕ ВНИМАНИЕ НА « .» В КОНЦЕ КОМАНДЫ)
<br>rm -rf .git
<br>sudo chmod -R 777 web/assets
<br>sudo chmod -R 777 web/img
<br>sudo chmod 777 runtime
<br>
<br><b>2.В файле config/db.php откорректируйте следующие строки настроек доступа к mysql(host, dbname, username, password) на свои параметры подключения к mysql:</b>
    <br>'dsn' => 'mysql:host=localhost;dbname=yii2-basic',
    <br>'username' => 'root',
    <br>'password' => '', 
<br>
<br><b>3.Запустите миграции для формирования таблиц бд(!обязательно после выполнения п.2):</b>
<br>php yii migrate 
<br>
<br><b>4.Запуск yii-приложения:</b>
<br>/workwers 
