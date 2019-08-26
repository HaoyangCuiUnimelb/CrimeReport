<?php

namespace api\controllers;


use app\models\UploadForm;
use common\models\MuserModel;
use common\models\PostModel;
use common\models\RelationPostTagModel;
use common\models\TagModel;
use SebastianBergmann\CodeCoverage\Util;
use yii\rest\ActiveController;
use Yii;
use yii\web\UploadedFile;


/**
 * PostController implements the CRUD actions for PostModel model.
 */
class PostController extends ActiveController
{
    public $modelClass = 'common\models\PostModel';

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

    /**
     * post upload function for mobile
     * @return array includes code; post id; username; title; content; category and location
     * @throws \yii\db\Exception
     */
    public function actionNew()
    {
        /**
         * using transaction to make sure data consistency
         */
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post = new PostModel();
            $tag = new TagModel();
            $tagRela = new RelationPostTagModel();
            $params = Yii::$app->request->post();
            $post->title = $params['title'];
            $post->content = "<p>" . $params['content'] . "</p>";
            $post->summary = $this->_getSummary($params['content']);
            $post->user_name = $params['user_name'];
            $post->cat_id = $params['cat_id'];
            $post->created_at = time();
            $post->updated_at = time();
            $user = MuserModel::findByUsername($params['user_name']);
            $post->user_id = $user->id;
            $post->label_img = $params["label_img"];
            $post->is_valid = PostModel::NO_VALID;

            if ($post->save()) {
                $res = $tag->find()->where(['tag_name' => $params['tag']])->one();
                if (!$res) {
                    $tag->tag_name = $params['tag'];
                    $tag->post_num = 1;
                    if ($tag->save()) {
                        $tagRela->tag_id = $tag->id;
                        $tagRela->post_id = $post->id;
                        $tagRela->save();
                    } else {
                        throw new \Exception('Save location failed!');
                    }
                } else {
                    $res->updateCounters(['post_num' => 1]);
                    $tagRela->tag_id = $res->id;
                    $tagRela->post_id = $post->id;
                    if (!$tagRela->save()) {
                        throw new \Exception('Post failed!');
                    }
                }
                $transaction->commit();
                return [
                    'error_code' => 200,
                    'res_msg' => [
                        'id' => $post->id,
                        'username' => $post->user_name,
                        'title' => $post->title,
                        'content' => $post->content,
                        'cat' => $post->cat_id,
                        'tag' => $res->tag_name == null ? $tag->tag_name : $res->tag_name,
                    ]
                ];
            } else {
                throw new \Exception('Post failed!');
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return [
                'error_code' => 500,
                'res_msg' => "Internal Error"
            ];
        }

    }

    /**
     * image upload function for mobile
     * @return array includes code and image url
     */
    public function actionUpload()
    {

        if (Yii::$app->request->isPost) {

            $model = new UploadForm();

            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstanceByName('file');
                if (($url = $model->upload()) == null) {
                    return [
                        'error_code' => 500,
                        'res_msg' => "Upload Failed",
                    ];
                } else {
                    return [
                        'error_code' => 200,
                        'image_url'=>$url,
                    ];
                }
            }
        }
    }

    /**
     *  get summary from uploaded content
     * @param $content
     * @return null|string
     */
        private
        function _getSummary($content)
        {
            if (empty($content))
                return null;
            return (mb_substr(str_replace('&nbsp;', '', strip_tags($content)), 0, 90, 'utf-8'));
        }
    }
