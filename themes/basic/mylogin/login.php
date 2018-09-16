<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\SurprisenewSearch;

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

<?php
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
    <?= $form->field($model_surprise, 'name')->textInput(array('placeholder'=>'', 'class'=>'login_field', 'value'=>'Something new'))->label('Name', array('class'=>'title_login_field'))->hint('(required)', array('class'=>'title_hint')); ?>
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
//$this->render('_search', ['model' => $searchModel_surprise])  //...(<?=)ÄÎÏÎËÍÈÒÅËÜÍÛÉ(ÍÅÒ Â ÒÀÁËÈÖÅ) ÔÈËÜÒÐ ÄËß GridView...
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
?>

<div class="clear_both"></div>

<div class="contatainer_country">
<h3><u>Table of items "Country"(not is modifying, only showing)</u></h3>
<?php
echo GridView::widget([
    'dataProvider' => $provider_country,

        'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'code',
           'name',
           'population',

        ],

]);
?>
</div>

<?php
} else {

echo '<h3>Access error</h3>';

}

?>

</div>