<?php
namespace frontend\models;
use common\models\TagModel;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: DennyLee
 * Form for tags
 */

class TagForm extends Model {
    public $id;

    public $tags;

    public function rules()
    {
        return [
            ['tags','required'],
            ['tags','each','rule'=>['string']],
        ];
    }

    /**
     * save tags batch
     * @return array
     */
    public function saveTags(){
        $ids = [];
        if (!empty($this->tags)){
            foreach ($this->tags as $tag){
                $ids[] = $this->_saveTag($tag);
            }
        }
        return $ids;
    }

    /**
     * save tag
     */
    private function _saveTag($tag){
        $model = new TagModel();
        $res = $model->find()->where(['tag_name'=> $tag])->one();
        if (!$res){
            $model->tag_name = $tag;
            $model->post_num = 1;
            if(!$model->save()) {
                throw new \Exception("Fail to save tag");
            }
                return $model->id;
            }else{
                $res->updateCounters(['post_num'=>1]);
            }
        return $res->id;
        }
}