<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\SurprisenewSearch;
use app\models\Country;

$session = Yii::$app->session;
if($session->get('id_user')) {

?>

<?php
$this->title = $model_surprise->title.' - login';
?>

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-mylogin-login']);
?>

<div class="contatainer">
<?= Html::tag('h3', 'Information for: '.Html::encode($session->get('name_user')), ['class' => 'username']) ?>
<?= Html::img('@web/img/'.$session->get('image_user'), ['alt' => 'Image of user', 'class' => 'img_user']) ?>
<?php
//'@web/img/'.$session->get('image_user')
//'@web/img/alex_image.jpg'
if($session->get('id_user')==1) {
?>

<div class="contatainer_surprise">
<h3><u>Table of items "Surprise"</u></h3>
<div class="contatainer_surprise_left">
<?php
    $form = ActiveForm::begin([
       'id' => 'add-form',
       'options' => ['class' => 'form-horizontal'],]);
    ?>
    <div class="form-group"><h4><u>Add new item</u></h4></div>
    <?= $form->field($model_surprise, 'name')->textInput(array('placeholder'=>'', 'class'=>'login_field', 'value'=>'New item'))->label('Name', array('class'=>'title_login_field'))->hint('(required)', array('class'=>'title_hint')); ?>
    <?= $form->field($model_surprise, 'limit_for_all')->textInput(array('placeholder'=>'', 'class'=>'login_field', 'value'=>'0'))->label('limit for all', array('class'=>'title_login_field'))->hint('(required, integer)', array('class'=>'title_hint')); ?>
    <?= $form->field($model_surprise, 'limit_for_one')->textInput(array('placeholder'=>'', 'class'=>'login_field', 'value'=>'0'))->label('limit for one', array('class'=>'title_login_field'))->hint('(required, integer)', array('class'=>'title_hint')); ?>
    <?= $form->field($model_surprise, 'status')->textInput(array('placeholder'=>'', 'class'=>'login_field', 'value'=>'0'))->label('status', array('class'=>'title_login_field'))->hint('(required, 0 or 1)', array('class'=>'title_hint')); ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
</div>

<div class="contatainer_surprise_right">
<div class="form-group"><h4><u>Search, update and delete of items</u></h4></div>

<?php
//$this->render('_search', ['model' => $searchModel_surprise])  //...(<?=)ДОПОЛНИТЕЛЬНЫЙ(НЕТ В ТАБЛИЦЕ) ФИЛЬТР ДЛЯ GridView...
?>

<?php
echo GridView::widget([
    'dataProvider' => $provider_surprise,
    'filterModel' => $searchModel_surprise,
        'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'name',
           ['label' => 'Limit for all', 'attribute' => 'limit_for_all'],
           ['label' => 'Limit for one', 'attribute' => 'limit_for_one'],
           ['label' => 'Status', 'attribute' => 'status'],
           ['label' => 'Username', 'attribute' => 'username'],
           ['class' => 'yii\grid\ActionColumn',
            'template' => '{leadDelete}{leadUpdate}',

            'buttons'  => [
                'leadDelete' => function ($url, $model) {
                    $url = Url::to(['mylogin/'.mb_strtolower($model->formName()).'-lead-delete', 'id' => $model->id]);
                    return Html::a('<div class="fa fa-delete" name="'.$model->formName().'">delete</div>', $url, [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    ]);
                },

                'leadUpdate' => function ($url, $model) {
                    $url = Url::to(['mylogin/'.mb_strtolower($model->formName()).'-lead-update', 'id' => $model->id]);
                    return Html::a('<div class="fa fa-update" name="'.$model->formName().'" value="'.$model->id.'">update</div>', $url, [
                    ]);
                },

              ],

           ],

        ],

]);
?>
</div>
</div>
<?php
}

if($session->hasFlash('id_add_item')) {
$id_add_item = $session->getFlash('id_add_item');
$js = <<<JS
$(document).ready(function(){
$("[data-key='$id_add_item']").css("font-weight", "bold").css("color", "red");
});
JS;
$this->registerJs($js);
}
if($session->hasFlash('id_update_item')) {
$id_update_item = $session->getFlash('id_update_item');
$js = <<<JS
$(document).ready(function(){
$("[data-key='$id_update_item']").css("font-weight", "bold").css("color", "blue");
$("tbody:eq(0)").prepend($("[data-key='$id_update_item']"));
});
JS;
$this->registerJs($js);
}

?>

<div class="clear_both"></div>

<div class="contatainer_country">
<h3><u>Table of items "Country"(not is modifying, only showing)</u></h3>
<?php
$dependency = [
    'class' => 'yii\caching\DbDependency',
    //???Изменение максимального
    //'sql' => 'SELECT MAX(population) FROM country',
    //Зависимость кеша от кол-ва записей
    'sql' => 'SELECT COUNT(*) FROM country',
];

//if ($this->beginCache('gridviewcountry', ['dependency' => $dependency])) {
if ($this->beginCache('gridviewcountry', ['variations' => $provider_country->getTotalCount()])) {  //...ЧТО ТО ЖЕ САМОЕ...
echo GridView::widget([
    'dataProvider' => $provider_country,

        'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'code',
           'name',
           'population',

        ],

]);
   $this->endCache();
?>



<?php
}
?>
</div>

<?php
} else {

echo '<h3>Access error</h3>';

}

?>

</div>