<?php


namespace common\bootstrap;


use frontend\urls\CategoryUrlRule;
use frontend\urls\PageUrlRule;
use shop\cart\Cart;
use shop\cart\cost\calculator\DynamicCost;
use shop\cart\cost\calculator\SimpleCost;
use shop\cart\storage\HybridStorage;
use shop\readModels\PageReadRepository;
use shop\readModels\shop\CategoryReadRepository;
use shop\repositories\UserRepository;
use shop\services\ContactService;
use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
use shop\services\RoleManager;
use yii\base\Application;
use yii\base\BootstrapInterface;
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
              //  [$app->params['supportEmail'] => 'Уведомления с сайта'],
              //  $app->params['adminEmail'],
                $app->mailer
            );
        });
/*
        $container->setSingleton(SignupService::class, function () {
            return new SignupService();
        });
        */
        $container->setSingleton('cache', function () use ($app) {
            return $app->cache;
        });
        $container->set(CategoryUrlRule::class, [], [
            Instance::of(CategoryReadRepository::class),
            Instance::of('cache'),
        ]);
        $container->set(PageUrlRule::class, [], [
            Instance::of(PageReadRepository::class),
            Instance::of('cache'),
        ]);
        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
               // new CookieStorage('cart', 3600*24*30),
                new DynamicCost(new SimpleCost())
            );
        });

        $container->setSingleton(RoleManager::class, function () use ($app) {
           return new RoleManager($app->get('authManager'));
        });
    }
}