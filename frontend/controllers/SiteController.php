<?php
namespace frontend\controllers;

use shop\forms\LoginForm;
use shop\services\AuthService;
use shop\forms\ResendVerificationEmailForm;
use shop\forms\VerifyEmailForm;
use shop\services\auth\ContactService;
use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
//use frontend\services\auth\VerificationService;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use shop\forms\PasswordResetRequestForm;
use shop\forms\ResetPasswordForm;
use shop\forms\SignupForm;
use shop\forms\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @var PasswordResetService
     */
    private $passwordResetService;
    /**
     * @var ContactService
     */
    private $contactService;
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(
        $id,
        $module,
        PasswordResetService $service,
        ContactService $contact,
        AuthService $authService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->passwordResetService = $service;
        $this->contactService = $contact;
        $this->authService = $authService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $form->password = '';
        return $this->render('login', ['model' => $form]);

    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                echo '<pre>';
                $this->contactService->contact($form);
                Yii::$app->session->setFlash('success', 'Спасибо за Ваш запрос, мы обязательно решим Вашу проблему и сообщим Вам.');
            } catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $form,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = (new SignupService())->signup($form);
            if (Yii::$app->getUser()->login($user))
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $form = new PasswordResetRequestForm();
       // $service = Yii::$container->get(PasswordResetService::class);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->passwordResetService->request($form);
            try {
                Yii::$app->session->setFlash('success', 'Проверьте вашу почту, ключ отправлен.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', 'Пользователь не найден');
            } catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('error', 'Ошибка отправки почты');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $this->passwordResetService->validateToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->reset($token, $form);
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $this->passwordResetService->verifyToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        try {
        $user = $this->passwordResetService->verifyEmail($token);
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Ваша почта подтверждена!');
                return $this->goHome();
            } {
                throw new \DomainException('Ошибка входа в систему');
            }
        } catch (\DomainException $e)
        {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }


        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $form = new ResendVerificationEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->VerificationEmail($form);
                Yii::$app->session->setFlash('success', 'Проверьте почту, мы Вам выслали инструкцию дальнейших действий.');
                return $this->goHome();
            } catch (\RuntimeException $e)
            {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('resendVerificationEmail', [
            'model' => $form
        ]);
    }
}
