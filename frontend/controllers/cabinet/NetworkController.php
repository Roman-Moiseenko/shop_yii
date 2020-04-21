<?php


namespace frontend\controllers\cabinet;

use shop\services\NetworkService;
use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class NetworkController extends Controller
{
    /**
     * @var NetworkService
     */
    private NetworkService $networkService;

    public function __construct($id, $module, NetworkService $networkService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->networkService = $networkService;
    }

    public function actions()
    {
        return [
            'attach' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client): void
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');

        try {
            $this->networkService->attach(Yii::$app->user->id, $network, $identity);
            Yii::$app->session->setFlash('success', 'Соцсеть присоединена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

}