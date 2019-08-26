<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/8/26
 * Time: 14:43
 */
namespace frontend\controllers;

/**
 * 文章控制器 Post Controller
 */
use common\models\CatModel;
use common\models\PostExtendModel;
use common\models\PostModel;
use frontend\models\PostForm;
use Yii;
use frontend\controllers\base\BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class PostController extends BaseController{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','upload','ueditor','verified'],
                'rules' => [
                    [
                        'actions' => ['index','verified'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create','upload','ueditor'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*'=>['get','post'],
                ],
            ],
        ];
    }
    /**
     * 文章列表 Post List
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * action verified post
     * @return string
     */
    public function actionVerified()
    {
        return $this->render('verified');
    }


    /**
     * verify function
     * @param $id
     * @return \yii\web\Response
     */
    public function actionVerify($id){
        $model = new PostModel();
        $res =$model->find()->where(['id'=> $id])->one();
        $res->is_valid = 1;
        $res->save();
        return $this->redirect(['post/verified']);
    }

    /**
     * 创建文章
     * @return string
     */
    public function actionCreate(){
        $model = new PostForm();
        //define scenario
        $model->setScenario(PostForm::SCENARIO_CREATE);
        if ($model->load(Yii::$app->request->post())&&$model->validate()){
            if (!$model->create()){
                Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['post/view','id'=>$model->id]);
            }
        }
        $cat = CatModel::getAllCats();
        return $this->render('create',['model'=>$model,'cat'=>$cat]);
    }

    /**
     * post detail
     */
    public function actionView($id){
        $model = new PostForm();
        $data = $model->getViewById($id);

        //view counter
        $model = new PostExtendModel();
        $model->updateCounters(['post_id'=>$id],'browser',1);
        return $this->render('view',['data'=>$data]);
    }

    /**
     * 图片上传插件 file upload
     * @return array
     */
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                 'class' => 'common\widgets\ueditor\UeditorAction',
                 'config'=>[
                     //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                 ]
            ],
        ];
    }
}