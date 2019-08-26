<?php
/**
 * Created by PhpStorm.
 * User: DennyLee
 * Date: 2018/10/12
 * Time: 21:08
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file','skipOnEmpty' => true, 'mimeTypes' => 'image/jpeg,image/png'],
        ];
    }

    /**
     * image upload function
     * @return null|string
     */
    public function upload()
    {
        if ($this->validate()) {
            $filePath = "C:/Users/HAOYANG/Downloads/UPUPW_AP7.2_64/UPUPW_AP7.2_64/vhosts/yii2-app-advanced-master/frontend/web/image/mobile/";
            $savePath = "/image/mobile/".$this->file->baseName.'.'.$this->file->extension;
            $this->file->saveAs($filePath.$this->file->baseName.'.'.$this->file->extension);
            return $savePath;
        } else {
            return null;
        }
    }
}
