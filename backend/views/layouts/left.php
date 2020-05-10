<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/ >
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Товары', 'icon' => 'dropbox', 'url' => ['/shop/product'], 'active' => Yii::$app->controller->id == 'shop/product'],
                    ['label' => 'Бренды', 'icon' => 'bank', 'url' => ['/shop/brand'], 'active' => Yii::$app->controller->id == 'shop/brand'],
                    ['label' => 'Метки', 'icon' => 'tags', 'url' => ['/shop/tag'], 'active' => $this->context->id == 'shop/tag'],
                    ['label' => 'Атрибуты', 'icon' => 'bars', 'url' => ['/shop/characteristic'], 'active' => $this->context->id == 'shop/characteristic'],
                    ['label' => 'Каталог', 'icon' => 'folder-open', 'url' => ['/shop/category'], 'active' => $this->context->id == 'shop/category'],
                    ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/user/index'], 'active' => $this->context->id == 'user'],
                    ['label' => 'Login', 'url' => ['auth/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Загрузка данных',
                        'items' => [
                            ['label' => 'Загрузка каталогов', 'url' => ['/data/load/catalog']],
                            ['label' => 'Загрузка товаров', 'url' => ['/data/load/products']],
                            ['label' => 'Обновить бренды', 'url' => ['/data/load/brands']],
                          //  ['label' => 'Проверка Hidden', 'url' => ['/data/load/temp']],
                        ],
                        ],

                    [
                        'label' => 'Разработчику',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>
</aside>
