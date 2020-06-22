<?php


namespace shop\repositories;


use shop\entities\shop\loaddata\File;

class FileRepository
{
    public function get($id): File
    {
        if (!$file = File::findOne($id))
            throw new NotFoundException('Not founded!');
        return $file;
    }

    public function save(File $file): void
    {
        if (!$file->save()) {
            throw new \RuntimeException('Not save!');
        }
    }
    public function remove($id): void
    {
        if (!$file = File::findOne($id)) {
            throw new NotFoundException('Not founded!');
        }
        if (!$file->delete()) {
            throw new \RuntimeException('Error delete!');
        }
    }
}