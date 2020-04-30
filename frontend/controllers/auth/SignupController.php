<?php


namespace frontend\controllers\auth;


use shop\forms\auth\SignupForm;
use shop\services\auth\SignupService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    public string $layout = 'cabinet';
    /**
     * @var SignupService
     */
    private SignupService $signupService;

    public function __construct($id, $module, SignupService $signupService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->signupService = $signupService;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $this->signupService->signup($form);
            if (Yii::$app->getUser()->login($user))
                return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }
}