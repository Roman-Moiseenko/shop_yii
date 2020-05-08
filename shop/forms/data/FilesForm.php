<?php

namespace shop\forms\data;

use yii\base\Model;
use yii\web\UploadedFile;

class FilesForm extends Model
{
    public $files;

    public function rules(): array
    {
        return [['files', 'each', 'rule' => ['text']]];
        //return [['catalog', 'rule' => ['*']], 'file', 'extensions' => 'out'];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');
            /*var_dump($this->files);
            die();*/
            return true;
        }
        return false;
    }

}