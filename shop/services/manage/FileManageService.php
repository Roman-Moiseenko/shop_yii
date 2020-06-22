<?php


namespace shop\services\manage;


use shop\entities\shop\loaddata\File;
use shop\repositories\FileRepository;
use shop\services\TransactionManager;

class FileManageService
{
    /**
     * @var FileRepository
     */
    private $files;
    /**
     * @var TransactionManager
     */
    private $transaction;

    public function __construct(FileRepository $files, TransactionManager $transaction)
    {
        $this->files = $files;
        $this->transaction = $transaction;
    }

    public function save(File $file)
    {
        $this->transaction->wrap(function () use ($file) {
            $this->files->save($file);
        });
    }

    public function remove($id): void
    {
        $files = $this->files->get($id);
        $this->files->remove($files);
    }
}