<?php

namespace shop\forms\data;

use yii\base\Model;
use yii\web\UploadedFile;

class FilesForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $file_catalog;

    public function rules()
    {
        return [
            [['file_catalog'], 'file', 'extensions' => 'out'],
        ];
    }

  /*  public function rules(): array
    {
        return [['files', 'each', 'rule' => ['text']]];
        //return [['catalog', 'rule' => ['*']], 'file', 'extensions' => 'out'];
    }*/

    public function upload()
    {

       // if ($this->validate()) {
           //die($this->file_catalog->baseName);
        //    echo 1;
        $file = $this->file_catalog->baseName . '.' . $this->file_catalog->extension;
            $this->file_catalog->saveAs('@staticRoot/data/' . $file);

            //  echo 2;
          // die();
            return $file;

    }

}