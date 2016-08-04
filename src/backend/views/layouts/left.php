<aside class="main-sidebar">

    <section class="sidebar">


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '首页', 'icon' => 'fa fa-home', 'url' => ['/']],
                    ['label' => '管理员设置', 'options' => ['class' => 'header']],
                    ['label' => '添加管理员', 'icon' => 'fa fa-user-plus', 'url' => ['/toolkit/admin-add']],
                    ['label' => '编辑管理员', 'icon' => 'fa fa-user', 'url' => ['/toolkit/admin-edit']],

                    ['label' => '数据库', 'options' => ['class' => 'header']],
                    ['label' => '执行SQL', 'icon' => 'fa fa-database', 'url' => ['/toolkit/execute-sql']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
