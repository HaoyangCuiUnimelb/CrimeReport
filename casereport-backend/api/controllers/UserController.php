<?php

namespace api\controllers;


use common\models\MuserModel;
use Yii;
use yii\rest\ActiveController;

/**
 * Class UserController
 * @package api\controllers
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\MuserModel';

    /**
     * unset create action
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return parent::actions();
    }

    public function actionLogin()
    {
        $params = Yii::$app->request->post();
        $user = MuserModel::findByUsername($params['username']);
        if (!$user) {
            return [
                'error_code' => 404,
                'res_msg' => "Username does not exist!"
            ];
        }
        if ($user->validatePassword($params['password'])) {
            return [
                'error_code' => 200,
                'res_msg' => [
                    'id' => $user->primaryKey,
                    'token' => $user->auth_key,
                ]
            ];
        } else {
            return
                ['error_code' => 400,
                    'res_msg' => "Wrong password!"
                ];
        }

    }

    public function actionReg()
    {
        $params = Yii::$app->request->post();
        $user = new MuserModel();
        $user->username = $params['username'];
        $findUser = MuserModel::findByUsername($params['username']);
        if (!$findUser) {
            $user->setPassword($params['password']);
            $user->generateAuthKey();
            $user->status = 10;
            if ($user->save()) {
                return [
                    'error_code' => 200,
                    'res_msg' => [
                        'id' => $user->primaryKey,
                        'email' => $user->username,
                        'token' => $user->auth_key,
                    ]
                ];

            } else {
                return [
                    'error_code' => 500,
                    'res_msg' => "Internal Error"
                ];
            }
        }else{
            return [
                'error_code' => 500,
                'res_msg' => "Username Existed!"
            ];
        }
    }
}
