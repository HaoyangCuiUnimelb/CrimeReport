<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/9/25
 * Time: 19:31
 */

use backend\assets\LoginAsset;
use yii\helpers\Html;


LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="signwrapper">
    <?php $this->beginBody() ?>

    <?=$content?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>