<?php

namespace api\controllers;


use common\models\PostModel;
use yii\rest\ActiveController;
use Yii;


/**
 * PostController implements the CRUD actions for PostModel model.
 */
class TagController extends ActiveController
{
    public $modelClass = 'common\models\TagModel';

}
