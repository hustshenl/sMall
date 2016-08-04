<?php
/**
 * $this->params结构
 * [
 * 'subTitle'=>'二级标题',
 * 'breadcrumbs'=>[
 *      'links' => [
 *           [
 *           'label' => 'Sample Post',
 *           'url' => ['post/edit', 'id' => 1]
 *          ],
 *          'Edit',
 *      ],
 *      'actions' => [
 * 'label' => 'Action',
 * 'button' => [
 * 'type' => Button::TYPE_FIT_HEIGHT ,
 * 'color' => Button::COLOR_GREY_SALT,
 * 'options' => ['data-hover' => 'dropdown', 'delay' => '1000'],
 * ],
 * 'dropdown' => [
 * 'items' => [
 * ['label' => 'DropdownA', 'url' => '/'],
 * ['divider'],
 * ['label' => 'DropdownB', 'url' => '#'],
 * ],
 * ],
 *      ]
 *  ],
 * ]
 */
/** @var $this \yii\web\View */
/** @var $content string */
use yii\helpers\Html;
use hustshenl\metronic\helpers\Layout;
use member\widgets\Menu;
use hustshenl\metronic\widgets\NavBar;
use hustshenl\metronic\widgets\Nav;
use hustshenl\metronic\widgets\Breadcrumbs;
use hustshenl\metronic\widgets\Button;
use member\widgets\HorizontalMenu;
use hustshenl\metronic\Metronic;
use member\widgets\Badge;
use hustshenl\metronic\widgets\Alert;
use hustshenl\metronic\bundles\NotificationAsset;
use kartik\icons\Icon;
use kartik\alert\AlertBlock;

// Initialize framework as per <code>icon-framework</code> param in Yii config
Icon::map($this);

Metronic::registerThemeAsset($this);
NotificationAsset::register($this);
$this->registerCssFile('@web/css/common.css', ['position' => $this::POS_HEAD, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$this->registerCssFile('@web/css/form.css', ['position' => $this::POS_HEAD, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$this->registerJs('App.init();SinMH.init();');
$this->registerJsFile("@web/js/notify.js", ['position' => $this::POS_END, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);
$this->registerJsFile("@web/js/common.js", ['position' => $this::POS_END, 'depends' => [\hustshenl\metronic\bundles\ThemeAsset::className()]]);

$this->beginPage();
?>
    <!DOCTYPE html>
    <!--[if IE 8]>
    <html lang="<?= Yii::$app->language ?>" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]>
    <html lang="<?= Yii::$app->language ?>" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="<?= Yii::$app->language ?>" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta name="renderer" content="webkit">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?>
            - <?= \yii\helpers\ArrayHelper::getValue(Yii::$app->config->get('siteInfo'), 'siteName', '会员中心'); ?></title>
        <?php $this->head() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta name="MobileOptimized" content="320">
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="/favicon.ico"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body <?= Layout::getHtmlOptions('body', ['class' => 'page-content-white page-md'], true) ?> >
    <!--[if lte IE 8]>
    <div class="ie8-warning-mask"></div>
    <div id="ie8-warning"><p>本页面采用HTML5+CSS3，您正在使用老版本 Internet Explorer ，在本页面的显示效果可能有差异。建议您升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 11</a> 或以下浏览器：
        <br>
        <a href="http://www.mozillaonline.com/"><?= Yii::$app->formatter->asImage("images/etc/browser-firefox.png") ?></a> /
        <a href="http://www.baidu.com/s?wd=google%E6%B5%8F%E8%A7%88%E5%99%A8"><?= Yii::$app->formatter->asImage("images/etc/browser-chrome.png") ?></a> /
        <a href="http://www.operachina.com/"><?= Yii::$app->formatter->asImage("images/etc/browser-opera.png") ?></a></p></div>
    <![endif]-->
    <?php $this->beginBody() ?>
    <!-- BEGIN NAV BAR -->
    <?php
    NavBar::begin(
        [
            'brandLabel' => '圣樱漫画管理系统',
            'brandLogoUrl' => '@web/images/logo.png',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => Layout::getHtmlOptions('header', false),
        ]
    );
    /*echo HorizontalMenu::widget(
        [
            'items' => [
                [
                    'label' => \Yii::t('member', 'All Menu'),
                    'type' => HorizontalMenu::ITEM_TYPE_MEGA,
                    'items' => [
                        [
                            //'options' => '',
                            'label' => '产品管理',
                            'items' => [
                                ['label' => '产品列表', 'url' => ['/product/index']],
                                ['label' => '产品分类', 'url' => ['/product/category']],
                            ]
                        ],
                        [
                            //'options' => '',
                            'label' => '权限管理',
                            'childUrl' => 'permission/index',
                            'items' => [
                                ['label' => 'Promo Page 2'],
                                ['label' => 'Email Templates 2'],
                            ]
                        ],
                    ]
                ],
            ],
            'search' => ['visible' => false],
        ]
    );*/
    echo '<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>';
    echo '<div class="top-menu">';
    echo Nav::widget(
        [
            'position' => Nav::POS_RIGHT,
            'items' => [
                /*[
                    'icon' => 'fa icon-bell',
                    'badge' => Badge::widget(['label' => '0', 'type' => Badge::TYPE_DANGER, 'options' => ['id' => 'notify-all']]),
                    'label' => \Yii::t('common', 'Home'),
                    'dropdownType' => Nav::TYPE_NOTIFICATION,
                    'url' => ['/'],
                    // dropdown title
                    //'title' => 'N条待处理信息',
                    //'more' => ['label' => 'More ', 'url' => '/', 'icon' => 'm-icon-swapright'],
                    // scroller
                    //'scroller' => ['height' => 200],
                    // end dropdown
                    'items' => [
                        [
                            //'icon' => 'icon-user',
                            'label' => '提醒',
                            'url' => ['#'],
                            'badge' => Badge::widget(['label' => '0', 'type' => Badge::TYPE_DANGER, 'options' => ['id' => 'notify-min5']]),
                        ],
                    ]
                ],*/
                [
                    'options'=>['class'=>'nav-item'],
                    'label' => '返回首页',
                    'url' => ['/home'],
                ],
                [
                    'label' => Nav::userItem(\Yii::$app->user->identity->username, \Yii::$app->user->identity->avatarUrl),
                    'icon' => 'fa fa-angle-down',
                    'url' => '#',
                    'dropdownType' => Nav::TYPE_USER,
                    'items' => [
                        [
                            'icon' => 'icon-user',
                            'label' => '个人资料',
                            'url' => ['/account'],
                            //'badge' => Badge::widget(['label' => 'xxx', 'type' => Badge::TYPE_SUCCESS]),
                        ],
                        [
                            'icon' => 'fa fa-edit ',
                            'label' => '修改资料',
                            'url' => ['/account/edit'],
                            //'badge' => Badge::widget(['label' => 'xxx', 'type' => Badge::TYPE_SUCCESS]),
                        ],
                        [
                            'icon' => 'icon-lock',
                            'label' => '修改密码',
                            'url' => ['/account/password'],
                            //'badge' => Badge::widget(['label' => 'xxx', 'type' => Badge::TYPE_SUCCESS]),
                        ],
                        [
                            'icon' => 'icon-users',
                            'label' => '修改头像',
                            'url' => ['/account/avatar'],
                            //'badge' => Badge::widget(['label' => 'xxx', 'type' => Badge::TYPE_SUCCESS]),
                        ],
                        ['divider'],
                        [
                            'icon' => 'icon-logout',
                            'label' => '退出登陆',
                            'url' => ['/account/logout'],
                        ],
                    ]
                ],
                /*[
                    'icon' => 'fa icon-logout',
                    'type' => Nav::TYPE_LOGOUT,
                    'label' => 'logout',
                    'url' => ['/member/logout'],
                ],*/
                // [ 'label' => 'Contact', 'url' => ['/site/contact']],
            ],
        ]
    );
    echo '</div>';
    NavBar::end();
    ?>
    <!-- END NAV BAR -->
    <?=
    (Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ?
        Html::beginTag('div', ['class' => 'container']) : '';
    ?>
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <?=
        Menu::widget(
            [
                'visible' => true,
                'items' => [
                    // Important: you need to specify url as 'controller/action',
                    // not just as 'controller' even if default action is used.
                    [
                        'icon' => 'fa fa-home',
                        'label' => \Yii::t('common', '我的个人中心'),
                        'url' => ['/'],
                        'childUrls' => ['site/index','account/index','account/edit','account/password','account/avatar'],
                    ],
                    /*[
                        'icon' => 'icon-envelope-open',
                        'label' => '我的消息',
                        'url' => ['comic/index'],
                    ],*/
                    /*[
                        'icon' => 'fa fa-home',
                        'label' => '返回首页',
                        'url' => ['/home'],
                    ],*/
                    [
                        'icon' => 'icon-heart',
                        'label' => '我的订阅',
                        'url' => ['/subscribe'],
                        'childUrls' => ['subscribe/index','subscribe/read'],
                    ],
                    [
                        'icon' => 'icon-pointer',
                        'label' => '阅读记录',
                        'url' => ['/history'],
                        'childUrls' => ['history/index'],
                    ],
                    /*[
                        'icon' => 'fa fa-credit-card',
                        'label' => '我的漫币',
                        'url' => ['/credit'],
                        'childUrls' => ['credit/index'],
                    ],*/
                    /*[
                        'icon' => 'icon-eye',
                        'label' => '我的关注',
                        'url' => ['comic/index'],
                    ],*/
                    [
                        'icon' => 'icon-user',
                        'label' => '作者认证',
                        'url' => ['/author/auth'],
                    ],
                    [
                        'icon' => 'fa fa-clone',
                        'label' => '我的作品',
                        'url' => ['/comic'],
                        'childUrls' => ['comic/index','comic/update-cover','chapter/index', 'chapter/update'],

                    ],
                    [
                        'icon' => 'icon-cloud-upload',
                        'label' => '新建漫画',
                        'url' => ['/comic/create'],
                        'childUrls' => ['/comic/create','comic/create-cover','comic/created'],

                    ],
                    [
                        'icon' => 'icon-volume-1',
                        'label' => '作者公告',
                        'url' => ['/author/notice'],
                    ],
                    /*[
                        'icon' => 'icon-share',
                        'label' => '投稿',
                        'url' => ['account/password'],
                    ],*/
                ],
            ]
        );
        ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE TITLE -->
                <!--<h3 class="page-title">
                    <? /*= Html::encode($this->title) */ ?>
                    <small><? /*= Html::encode(@$this->params['subTitle']) */ ?></small>
                </h3>-->
                <!-- END PAGE TITLE -->
                <div class="page-bar">
                    <!-- BEGIN BREADCRUMB-->
                    <?= Breadcrumbs::widget(
                        [
                            'actions' => @$this->params['breadcrumbs']['actions'],
                            'homeLink' => [
                                'label' => \Yii::t('common', 'Home'),
                                'icon' => 'fa fa-home',
                                'url' => ['/']
                            ],
                            'links' => @$this->params['breadcrumbs']['links'],
                        ]
                    );
                    ?>
                </div>
                <!--<h3 class="page-title"><? /*= $this->title */ ?>
                    <small><? /*= $this->params['subTitle'] */ ?></small>
                </h3>-->
                <div style="height: 1em;width: 100%;"></div>
                <?php
                /*                $session = Yii::$app->getSession();
                                $flashes = $session->getAllFlashes();
                                foreach ($flashes as $type => $message) {
                                    echo Alert::widget([
                                        'type' => $type,
                                        'body' => $message,
                                        'options' => ['class' => 'Metronic-alerts']
                                    ]);
                                    $session->removeFlash($type);
                                }
                                */ ?>
                <?= AlertBlock::widget([
                    'useSessionFlash' => true,
                    'type' => AlertBlock::TYPE_ALERT
                    //'type' => AlertBlock::TYPE_GROWL
                ]); ?>
                <? /*= Alert::widget(['options' => ['class' => 'Metronic-alerts']]) */ ?>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <?= $content ?>
                <!-- END PAGE CONTENT-->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner">
            <?= \yii\helpers\ArrayHelper::getValue(Yii::$app->config->get('siteInfo'), 'siteCopyright', '2014-' . date('Y') . ' &copy; SHENL.COM.'); ?>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <?= (Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ? Html::endTag('div') : ''; ?>
    <?php $this->endBody() ?>
    </body>
    <!-- END BODY -->
    </html>
<?php



$this->endPage();
?>