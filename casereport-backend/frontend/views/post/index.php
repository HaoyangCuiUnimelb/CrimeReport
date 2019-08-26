<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/8/26
 * Time: 14:51
 */

$this->title = 'Cases in progress';
$this->params['breadcrumbs'][] =['label'=>'Case','url'=>['post/index']];
$this->params['breadcrumbs'][] = $this->title;
use frontend\widgets\post\PostWidget;
?>
<div class="row">
    <div class="col-lg-9">
        <?=PostWidget::widget() ?>
    </div>
    <div class="col-lg-3">

    </div>
</div>