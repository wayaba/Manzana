<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
        <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <?php $this->head() ?>
    
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?=Url::to( ['site/index'] ) ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>N</b>L</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>NEW </b>LOOK</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
              <?php
              echo Html::beginForm(['/site/logout'], 'post',['class'=>'signout']);
              ?>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li>
                <a href="#" id="sing-out"><i class="fa  fa-sign-out"></i></a>
                <?php 
					$this->registerJs("
						$('#sing-out').click(function(){
					    	$('form.signout').submit();
					    });
					");?>
              </li>
            </ul>
          </div>
              <?php 
              echo Html::endForm();
              ?>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <!-- search form -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Menú principal</li>
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="active"><a href="<?=Url::to( ['socio/index'] ) ?>"><i class="fa fa-circle-o"></i> Socios</a></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Panel de control</small>
          </h1>
          <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        	]) ?>
          
        </section>
        <!-- Main content -->
        <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
          <!-- Small boxes (Stat box) -->
          <!-- Main row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2016-2016 <a href="http://domasolutions.com">Domasolutions</a>.</strong> Todos los derechos reservados.
      </footer>
    </div><!-- ./wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

	<?php $this->endBody() ?>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    
    
  </body>
</html>
<?php $this->endPage() ?>
