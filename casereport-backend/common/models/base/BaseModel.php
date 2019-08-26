<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/8/26
 * Time: 15:13
 */
namespace common\models\base;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord{
    public function getPages($query,$curPage = 1,$pageSize = 10,$search = null){
        if ($search){
            $query = $query->andFilterWhere($search);
        }
        $data['count'] = $query->count();
        if(!$data['count']){
            return [
                'count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,'end'=>0,'data'=>[]
            ];
        }
        //
        $curPage = (ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize):$curPage;
        //current page
        $data['curPage'] = $curPage;
        //start page
        $data['start'] = ($curPage-1)*$pageSize+1;
        //end page
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage)?
            $data['count']:($curPage-1)*$pageSize+$pageSize;
        //data
        $data['data'] = $query
            ->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            ->asArray()
            ->all();
        return $data;
    }
}