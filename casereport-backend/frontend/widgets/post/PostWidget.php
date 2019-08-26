<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/9/16
 * Time: 17:44
 */
namespace frontend\widgets\post;
/**
 * post list
 */
use common\models\PostModel;
use frontend\models\PostForm;
use yii\helpers\Url;
use Yii;
use yii\base\Widget;
use yii\data\Pagination;

class PostWidget extends Widget{
    /**
     * the title of post
     * @var string
     */
    public $title = '';

    /**
     * post each page
     * @var int
     */
    public $limit = 5;

    /**
     * view more cases
     * @var bool
     */
    public $more = true;

    /**
     * Pagination
     * @var bool
     */
    public $page = true;

    public function run(){
        $curPage = Yii::$app->request->get('page',1);
        $condition = ['=','is_valid',PostModel::NO_VALID];
        $res = PostForm::getList($condition,$curPage,$this->limit);
        $result['title'] = $this->title?:'Case';
        $result['more'] = Url::to(['post/index']);
        $result['body'] = $res['data']?:[];
        if($this->page){
            $pages = new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
            $result['page'] = $pages;
        }
        return $this->render('index',['data'=>$result]);
    }
}