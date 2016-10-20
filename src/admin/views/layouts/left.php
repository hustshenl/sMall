<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel hide">
            <div class="pull-left image">
                <?= Yii::$app->formatter->asImage(Yii::$app->user->identity->avatar, ['default' => 'images/default/avatar.png', 'class' => 'img-circle']); ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
                <p><?= Yii::$app->user->identity->nickname ?></p>
            </div>
        </div>

        <!-- search form -->
        <form action="/menu/search" method="get" class="sidebar-form hide">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php
        $items = common\helpers\MenuHelper::getAssignedMenu(Yii::$app->user->id, null,
            function ($menu) {
                $data = json_decode($menu['data'], true);
                if (!is_array($data)) $data = [];
                $item = ['label' => $menu['name'],
                    'url' => [$menu['route']],
                    'items' => $menu['children']
                ];
                if (isset($data['options']) && is_array($data['options'])) $item['options'] = $data['options'];
                if (isset($data['routes']) && is_array($data['routes'])) $item['routes'] = $data['routes'];
                if (isset($data['icon']) && is_string($data['icon'])) $item['icon'] = $data['icon'];
                return $item;
            }
        );
        ?>
        <?= admin\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => array_merge(
                    [
                        ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ],
                    $items),
                /*'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],*/
            ]
        ) ?>


    </section>

</aside>
