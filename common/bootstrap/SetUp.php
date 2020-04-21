<?php


namespace common\bootstrap;


use shop\repositories\UserRepository;
use shop\services\auth\ContactService;
use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
use yii\base\Application;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(PasswordResetService::class, function () use ($app) {
            return new PasswordResetService(
                [$app->params['supportEmail'] => $app->name . ' robot'],
                $app->mailer,
                new UserRepository());
        });

        $container->setSingleton(ContactService::class, function () use ($app) {
            return new ContactService(
                [$app->params['supportEmail'] => $app->name . ' robot'],
                $app->params['adminEmail'],
                $app->mailer
            );
        });

        $container->setSingleton(SignupService::class, function () {
            return new SignupService();
        });
    }
}