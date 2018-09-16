<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\widgets\HelloWidget;
use yii\widgets\Menu;
use yii\imagine\Image;
use yii\helpers\Url;
//print_r($row_db_result);
$session = Yii::$app->session;
?>

<?php
$this->title = 'title-ready';
//$this->title = $model->title;
?>

<?php
//$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-ready - yii, framework, php']);
?>

<?php
// создает URL для маршрута: /index.php?r=post/index
//echo Url::to(['post/index']); echo '<br>';

// запрошенный маршрут: /index.php?r=admin/post/index
echo Url::to(['']); echo '<br>';

// URL из псевдонима: http://example.com
Yii::setAlias('@example', 'http://example.com/');
echo Url::to('@example'); echo '<br>';  // http://example.com

// абсолютный URL: http://example.com/images/logo.gif
echo Url::to('/images/logo.gif', true); echo '<br>'; // http://yii2.25one.com.ua/images/logo.gif

// домашний URL: /index.php?r=site/index
echo Url::home(); echo '<br>'; // /web/index.php

// базовый URL, удобно использовать в случае, когда приложение расположено в подкаталоге
// относительно корневого каталога Веб сервера
echo Url::base(); echo '<br>'; // /web

?>

<?php
echo Menu::widget([  //...СТАНД.ВИДЖЕТ "МЕНЮ"...
    'activateItems' => false,
    'items' => [
        ['label' => 'Home', 'url' => ['mymod/index']],     //...СВОЙ url...
        ['label' => 'Products', 'url' => ['product/index']], //...НУЖЕН СВОЙ url...
        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest], //...НУЖЕН СВОЙ url (?'visible')...
    ],
]);
?>

<br>
<?php
//Image::thumbnail('@webroot/img/myphoto.jpg', 120, 120)->save(Yii::getAlias('@runtime/thumb-test-image.jpg'), ['quality' => 50]);
print_r(Yii::getAlias('@webroot')); echo '<br>'; //...ВО view УЖЕ ЕСТЬ...
Yii::setAlias('@webimg', '@webroot/img'); //... @webimg ВМЕСТО @webroot/img... - @webimg ВМЕСТО @webroot/img/151_0275.jpg...
Image::thumbnail('@webimg/151_0275.jpg', 120, 120)->save(Yii::getAlias('@webimg/151_0275.jpg'), ['quality' => 100]);
//???НЕ РАБОТАЕТ - web.php - 'aliases' => [... '@webrootimg' => '@webroot/img', - ...???ВЕРОЯТНО, ЕЩЕ НЕТ @webroot - ВО view УЖЕ ЕСТЬ...
?>

<img src="img/151_0275.jpg" alt="" />

<p>Ready: <?= HelloWidget::widget(['id_user' => $session->get('id_user'), 'message' => 'Hello...']) ?></p>

<h2><?= Html::encode($model->from_date).' - from_date' ?></h2>

<ul>
<div class="user_write">
    <!-- This go from user: <?= Html::encode('<b>'.$model->login.'</b>') ?> -->  <!-- html НЕ ИНТЕРПРИТИРУЕТ... -->
    This go from user: <?= HtmlPurifier::process('<b>'.$model->login.'</b>') ?> <!-- html ИНТЕРПРИТИРУЕТ... -->
</div>
<hr>
<div class="db_write">
    This go from session and db:
    <li><label>session</label>: <?php echo $session->get('id_user'); ?></li>
    <li><label>id</label>: <?php echo $row_db_result[0]['id']; ?></li>
    <li><label>login</label>: <?php echo $row_db_result[0]['login']; ?></li>
    <li><label>password</label>: <?php echo $row_db_result[0]['password']; ?></li>
    <li><label>baseapi</label>: <?php echo $modelbase->baseapi; //...РАСШИРЕНИЕ МОДЕЛИ - ?И НЕ МАССИВ... ?></li>
    <li>
    <label>orders</label>:<br>
    <?php
    if(is_array($order_title)) {
       foreach($order_title as $order) {
         echo $order.'<br>';
       }
    }
    ?>
    </li>
</div>
</ul>

<!-- <?= $this->render('_overview') ?> --> <!-- ...ПРОСТО ТИПА require_once... -->


<?php
// показывает файл "@app/views/site/license.php"
$this->params['hello'] = 'Hello...';
echo \Yii::$app->view->renderFile('@app/views/mymod/_overview.php'); //...ИЛИ ТАК - АНАЛОГ ВВЕРХУ...
?>

<?= $this->renderAjax('_overviewajax'); ?> <!-- ...ajax + JS(CSS) ДОБАВЛЯЕТ (ЗАРЕГИСТРИРОВАННЫЕ В _overviewajax.php)... -->

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-ready - yii, framework, php']);  //...!!!ИЗ-ЗА ajax ПОЧЕМУ-ТО НУЖНО ТУТ...
?>

<button type="button" class="button_hello">Go to "Hello"...</button>
<button type="button" class="button_nature">Go to "Nature"...</button>
<button type="button" class="button_module_forum">Go to module "forum"...</button>
<br><br>
