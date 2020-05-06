<?php


namespace common\bootstrap;


use frontend\urls\CategoryUrlRule;
use shop\readModels\shop\CategoryReadRepository;
use shop\repositories\UserRepository;
use shop\services\auth\ContactService;
use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
use yii\di\Instance;

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
        $container->setSingleton('cache', function () use ($app) {
            return $app->cache;
        });
        $container->set(CategoryUrlRule::class, [], [
            Instance::of(CategoryReadRepository::class),
            Instance::of('cache'),
        ]);
    }
}