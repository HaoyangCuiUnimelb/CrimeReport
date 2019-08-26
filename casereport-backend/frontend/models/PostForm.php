<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/8/26
 * Time: 15:20
 */
namespace frontend\models;
use common\models\PostModel;
use common\models\RelationPostTagModel;
use PHPUnit\Framework\Exception;
use yii\base\Model;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class PostForm extends Model{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;

    public $_lastError="";

    /**
     * Define scenarios create and update
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * Define event after create and update
     */
    const EVENT_AFTER_CREATE = "eventAfterCreate";
    const EVENT_AFTER_UPDATE = "evetnAfterUpdate";

    /**
     * set scenarios
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_CREATE =>['title','content','label_img','cat_id','tags'],
            self::SCENARIO_CREATE =>['title','content','label_img','cat_id','tags'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }

    public function rules()
    {
        return [
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>4,'max'=>50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'CaseID',
            'title'=>'Title',
            'content'=>'Content',
            'label_img'=>'Image',
            'tags'=>'Tags',
            'cat_id'=>'Category',
        ];
    }

    public static function getList($condition,$curPage=1,$pageSize=5,$orderBy = ['id'=>SORT_DESC]){
        $model = new PostModel();

        $select = [
            'id','title','summary','label_img','cat_id','user_name','is_valid','created_at','updated_at'
        ];
        $query = $model->find()
            ->select($select)
            ->where($condition)
            ->with('relate.tag','extend')
            ->orderBy($orderBy);
        //get data of pages
        $res = $model->getPages($query,$curPage,$pageSize);
        //format
        $res['data'] = self::_formatList($res['data']);
        return $res;
    }

    /**
     * data format
     * @param $data
     * @return mixed
     */
    public static function _formatList($data){
        foreach ($data as &$list){
            $list['tags'] = [];
            if(isset($list['relate'])&&!empty($list['relate'])){
                foreach ($list['relate'] as $lt) {
                    $list['tags'][] = $lt['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }
        return $data;
    }

    /**
     * create post
     * @return bool
     */
    public function create()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new PostModel();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid = PostModel::IS_VALID;
            $model->created_at = time();
            $model->updated_at =time();
            if (!$model->save())
                throw new \Exception('Post failed!');
            $this->id = $model->id;

            //invoke transaction,
            $data = array_merge($this->getAttributes(),$model->getAttributes());
            $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        }catch (\Exception $exception){
            $transaction->rollBack();
            $this->_lastError = $exception->getMessage();
            return false;
        }
    }

    public function getViewById($id){
        $res = PostModel::find()->with('relate.tag','extend')->where(["id"=>$id])->asArray()->one();
        if(!$res){
            throw new NotFoundHttpException('There is no post');
        }
        //handle tag format
        $res['tags']=[];
        if(isset($res['relate'])&&!empty($res['relate'])){
            foreach ($res['relate'] as $list) {
                $res['tags'][] = $list['tag']['tag_name'];
            }
        }
        unset($res['relate']);
        return $res;

    }

    /**
     * get summary of post
     * @param int $s
     * @param int $e
     * @param string $char
     * @return null|string
     */
    private function _getSummary($s = 0,$e = 90,$char = 'utf-8'){
        if (empty($this->content))
            return null;
        return(mb_substr(str_replace('&nbsp;','',strip_tags($this->content)),$s,$e,$char));
    }

    /**
     * set event after create
     * @param $data
     */
    private function _eventAfterCreate($data){
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /**
     * add tag
     */
    public function _eventAddTag($event){
        //save tags
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagids = $tag->saveTags();

        //delete existed tags relation when update
        RelationPostTagModel::deleteAll(['post_id'=> $event->data['id']]);

        //save
        if (!empty($tagids)){
            foreach ($tagids as $k => $id) {
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id']= $id;
            }
            $res = (new Query())->createCommand()
                ->batchInsert(RelationPostTagModel::tableName(),['post_id','tag_id'],$row)
                ->execute();
            if(!$res)
                throw new Exception("Fail to save relationship between tags and post");
        }
    }
}

