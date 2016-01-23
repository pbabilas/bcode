{use class="yii\helpers\Html"}
{use class="yii\bootstrap\Nav"}
{use class="yii\bootstrap\NavBar"}
{use class="yii\widgets\Breadcrumbs"}
{use class="app\assets\AdminAsset"}
{use class="app\common\widgets\Menu"}
{use class="Yii"}


{AdminAsset::register($this)|void}

{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{Html::encode($this->title)}</title>
        <base href="{\Yii::$app->getRequest()->getHostInfo()}">
        {$this->head()}
        {Html::csrfMetaTags()}
    </head>
    <body class="sidebar-mini skin-green">
        <div class="wrap">
            {$this->beginBody()}

            <header class="main-header">

                <!-- Logo -->
                <a href="/admin" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    {literal}
                    <span class="logo-mini"><strong>{b}</strong></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><strong>{b-code}</strong></span>
                    {/literal}
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    {$user = Yii::$app->user->identity}
                                    <img src="{$user->getPictureUrl($user->picture_filename, '25x25')}" class="user-image" alt="User Image">
                                    <span class="hidden-xs">`user.logged_as` {$user->name}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{$user->getPictureUrl($user->picture_filename, '90x90')}" class="img-circle" alt="User Image">
                                        <p>
                                            {$user->name}
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">`user.profile`</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="admin/user/auth/logout" class="btn btn-default btn-flat">`user.logout`</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                        </ul>
                    </div>

                </nav>
            </header>

            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <div class="slimScrollDiv"><div class="sidebar" id="scrollspy">
                        {$controllerName = Yii::$app->controller->id}
                        {$moduleName = Yii::$app->controller->module->id}
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                        {Menu::widget([
                            'itemsList' => Yii::$app->controller->menuItems
                        ])}
                </div>
                <div class="slimScrollBar">

                </div>
                <div class="slimScrollRail">

                </div>
                <!-- /.sidebar -->
            </aside>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1>
                        {Yii::$app->controller->currentModule->long_name}
                        <small>v. {number_format(Yii::$app->controller->currentModule->version, 2)}</small>
                    </h1>


                    {if $moduleHeader = Yii::$app->controller->module->getHeaderContent()}
                        {include file=$moduleHeader}
                    {elseif isset($this->params['breadcrumbs'])}
                        {Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'],
                        'homeLink' => [
                        'label' => 'Home',
                        'url' => '/admin/dashboard'
                        ]
                        ])}
                    {/if}
                </section>

                <div class="content">

                {if Yii::$app->session->hasFlash('alert')}
                    {foreach Yii::$app->session->getFlash('alert') as $message}
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-ban"></i> {$message|replace:'\n':'<br />'}
                        </div>
                    {/foreach}
                {/if}
                {if Yii::$app->session->hasFlash('info')}
                    {foreach Yii::$app->session->getFlash('info') as $message}
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-info"></i> {$message|replace:'\n':'<br />'}
                        </div>
                    {/foreach}
                {/if}

                {$content}
                </div>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 0.1.2
                </div>
                &copy; B-code.pl {date('Y')}
            </footer>

            {$this->endBody()}
        </div>
    </body>
</html>
{$this->endPage()}
