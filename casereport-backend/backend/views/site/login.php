<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sign-overlay"></div>
<div class="signpanel"></div>

<div class="panel signin">
    <div class="panel-heading">
        <h2 class="panel-title">Welcome to </h2>
        <h2 class="panel-title">CaseReport Management</h2>
        <h2 class="panel-title">Back-end</h2>
    </div>
    <div class="panel-body">
        <!--        <button class="btn btn-primary btn-quirk btn-fb btn-block">Contact</button>-->
        <div class="or">**</div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username', [
            'inputOptions' => [
                'placeholder' => 'Please input username',
            ],
            'inputTemplate' => '<div class = "input-group"><span class="input-group-addon"><i class="fa fa-user"></i> </span>{input}</div>'
        ])->label(false)->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password',[
            'inputOptions' => [
                'placeholder' => 'Please input password',
            ],
            'inputTemplate' => '<div class = "input-group"><span class="input-group-addon"><i class="fa fa-lock"></i> </span>{input}</div>'
        ])->passwordInput()->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-quirk btn-block', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div><!-- panel -->



