<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/9/16
 * Time: 16:15
 */
use yii\helpers\Url;

$this->title = $data['title'];
$this->params['breadcrumbs'][]=['label'=>'post','url'=>['post/index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="page-title">
            <h1><?=$data['title']?></h1>
            <span>Posted By: <?=$data['user_name']?> </span>
            <span>Posted At: <?=date('Y-m-d H:m:s',$data['created_at'])?> </span>
            <span>Updated At: <?=date('Y-m-d H:m:s',$data['updated_at'])?> </span>
            <span>View:<?=isset($data['extend']['browser'])?($data['extend']['browser']):0 ?></span>
        </div>
        <div class="page-tag">
            Location:
            <?php foreach ($data['tags'] as $tag):?>
                <span><a href="#"><?=$tag?></a> </span>
            <?php endforeach;?>
        </div>
        <br>
        <div class="page-content">
            <?=$data['content'] ?>
            <img src=<?=$data['label_img']?>>
        </div>
        <div>
            <br>
            <a href="<?=Url::to(['post/verify','id'=>$data['id']])?>">
                <button class="btn btn-warning no-radius btn-sm pull-left">Verify</button></a>
        </div>

    </div>
    <div class="col-lg-3">

    </div>
</div>