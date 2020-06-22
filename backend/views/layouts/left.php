<?php


use dmstr\widgets\Menu; ?>
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
        <?= Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Заказы', 'icon' => 'cart-plus', 'url' => ['/shop/order'], 'active' => Yii::$app->controller->id == 'shop/order'],
                    ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/user/index'], 'active' => $this->context->id == 'user'],
                    ['label' => 'Параметры', 'icon' => 'info', 'url' => ['/data/params'], 'active' => $this->context->id == 'data/params'],
                    ['label' => 'Магазин', 'icon' => 'building-o',
                        'items' => [
                            ['label' => 'Скидки', 'icon' => 'money', 'url' => ['/shop/discount'], 'active' => Yii::$app->controller->id == 'shop/discount'],
                            ['label' => 'Доставка', 'icon' => 'truck', 'url' => ['/shop/delivery-method'], 'active' => $this->context->id == 'shop/delivery-method'],
                            ['label' => 'Каталог', 'icon' => 'folder-open', 'url' => ['/shop/category'], 'active' => $this->context->id == 'shop/category'],
                            ['label' => 'Товары', 'icon' => 'dropbox', 'url' => ['/shop/product'], 'active' => Yii::$app->controller->id == 'shop/product'],
                            ['label' => 'Бренды', 'icon' => 'bank', 'url' => ['/shop/brand'], 'active' => Yii::$app->controller->id == 'shop/brand'],
                            ['label' => 'Метки', 'icon' => 'tags', 'url' => ['/shop/tag'], 'active' => $this->context->id == 'shop/tag'],
                            ['label' => 'Атрибуты', 'icon' => 'bars', 'url' => ['/shop/characteristic'], 'active' => $this->context->id == 'shop/characteristic'],
                            ['label' => 'Регулярки', 'icon' => 'registered', 'url' => ['/data/reg-attribute'], 'active' => $this->context->id == 'data/reg-attribute'],
                            ['label' => 'Отзывы', 'icon' => 'commenting', 'url' => ['/shop/review'], 'active' => $this->context->id == 'shop/review'],
                        ],
                    ],
                    ['label' => 'Блог', 'icon' => 'file-text',
                        'items' => [
                            ['label' => 'Статьи', 'icon' => 'book', 'url' => ['/blog/post'], 'active' => $this->context->id == 'blog/post'],
                            ['label' => 'Категории', 'icon' => 'folder-open', 'url' => ['/blog/category'], 'active' => $this->context->id == 'blog/category'],
                            ['label' => 'Метки', 'icon' => 'tags', 'url' => ['/blog/tag'], 'active' => $this->context->id == 'blog/tag'],
                            ['label' => 'Комментарии', 'icon' => 'commenting-o', 'url' => ['/blog/comment'], 'active' => $this->context->id == 'blog/comment'],
                        ],
                    ],
                    ['label' => 'Страницы', 'icon' => 'paste',
                        'items' => [
                            ['label' => 'Страницы', 'icon' => 'paste', 'url' => ['/page'], 'active' => $this->context->id == 'page'],
                            ['label' => 'Файлы', 'icon' => 'file-o', 'url' => ['/file'], 'active' => $this->context->id == 'file'],
                        ],
                    ],
                    ['label' => 'Login', 'url' => ['auth/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Загрузка данных', 'icon' => 'cloud-upload',
                        'items' => [
                            ['label' => 'Загрузка каталогов', 'icon' => 'upload', 'url' => ['/data/load/catalog']],
                            ['label' => 'Загрузка товаров', 'icon' => 'upload', 'url' => ['/data/load/products']],
                            ['label' => 'Обновить бренды', 'icon' => 'save', 'url' => ['/data/load/brands']],
                            ['label' => 'Обновить атрибуты', 'icon' => 'save', 'url' => ['/data/load/attributes']],
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
