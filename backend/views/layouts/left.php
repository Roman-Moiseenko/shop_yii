<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/ >
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Скидки', 'icon' => 'money', 'url' => ['/shop/discount'], 'active' => Yii::$app->controller->id == 'shop/discount'],
                    ['label' => 'Каталог', 'icon' => 'folder-open', 'url' => ['/shop/category'], 'active' => $this->context->id == 'shop/category'],
                    ['label' => 'Товары', 'icon' => 'dropbox', 'url' => ['/shop/product'], 'active' => Yii::$app->controller->id == 'shop/product'],
                    ['label' => 'Бренды', 'icon' => 'bank', 'url' => ['/shop/brand'], 'active' => Yii::$app->controller->id == 'shop/brand'],
                    ['label' => 'Доставка', 'icon' => 'truck', 'url' => ['/shop/delivery-method'], 'active' => $this->context->id == 'shop/delivery-method'],
                    ['label' => 'Метки', 'icon' => 'tags', 'url' => ['/shop/tag'], 'active' => $this->context->id == 'shop/tag'],
                    ['label' => 'Атрибуты', 'icon' => 'bars', 'url' => ['/shop/characteristic'], 'active' => $this->context->id == 'shop/characteristic'],

                    ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/user/index'], 'active' => $this->context->id == 'user'],
                    ['label' => 'Регулярки', 'icon' => 'registered', 'url' => ['/data/reg-attribute'], 'active' => $this->context->id == 'data/reg-attribute'],
                    ['label' => 'Login', 'url' => ['auth/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Загрузка данных',
                        'items' => [
                            ['label' => 'Загрузка каталогов', 'icon' => 'upload', 'url' => ['/data/load/catalog']],
                            ['label' => 'Загрузка товаров', 'icon' => 'upload', 'url' => ['/data/load/products']],
                            ['label' => 'Обновить бренды', 'icon' => 'save', 'url' => ['/data/load/brands']],
                            ['label' => 'Обновить Аттрибуты', 'icon' => 'save', 'url' => ['/data/load/attributes']],
                        ],
                    ],

                    [
                        'label' => 'Разработчику',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Закрой и не открывай,', 'icon' => 'share', 'url' => ['/'],],
                            ['label' => 'сломаешь что-нибудь!', 'icon' => 'share', 'url' => ['/'],],
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>
</aside>
