<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/9/16
 * Time: 21:39
 */
use frontend\widgets\post\PostWidgetVerified;

$this->title = 'Verified Cases';
$this->params['breadcrumbs'][] =['label'=>'Case','url'=>['post/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <?=PostWidgetVerified::widget() ?>
    </div>
    <div class="col-lg-3">

    </div>
</div>