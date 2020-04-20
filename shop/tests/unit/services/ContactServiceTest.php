<?php

namespace shop\tests\unit\services;
use Codeception\Test\Unit;
use shop\services\auth\ContactService;
use yii\mail\MailerInterface;
use yii\mail\MessageInterface;

class ContactServiceTest extends Unit
{
 public function testContact()
 {
     $mailer = new DumpMailer();
     $contact = new ContactService('test1', 'test2', $mailer);
 }

}

class DumpMailer implements MailerInterface
{

    /**
     * @inheritDoc
     */
    public function compose($view = null, array $params = [])
    {
        // TODO: Implement compose() method.
    }

    /**
     * @inheritDoc
     */
    public function send($message)
    {
        // TODO: Implement send() method.
    }

    /**
     * @inheritDoc
     */
    public function sendMultiple(array $messages)
    {
        // TODO: Implement sendMultiple() method.
    }
}