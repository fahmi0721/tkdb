<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title_page ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('public/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/dataTables.bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/datepicker3.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/bootstrap3-wysihtml5.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/_all-skins.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/jquery-ui.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/lib/select2-bootstrap/dist/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/lib/select2-bootstrap/dist/select2-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/css/main.css') ?>">
 
  <script src="<?= base_url() ?>/public/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>/public/js/jquery-ui.min.js"></script>
  
</head>

<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TK</b>DB</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TKDB </b> ONLINE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url() ?>/public/img/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= strtoupper($this->session->userdata('Nama')) ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url() ?>/public/img/avatar.png" class="img-circle" alt="User Image">

                <p>
                <?= strtoupper($this->session->userdata('Username')) ?>
                  <small><?= strtoupper($this->session->userdata('Level')) ?></small>
                </p>
              </li>
              <li class="user-footer">
               
                <div class="pull-right">
                  <?php if($this->session->userdata('Level') == "Admin"){ ?>
                    <a href="<?= base_url('admins/auths/').$this->session->userdata('Link-Logout') ?>" class="btn btn-danger btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                  <?php }else{ ?>
                    <a href="<?= base_url('auths/').$this->session->userdata('Link-Logout') ?>" class="btn btn-danger btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                  <?php } ?>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url() ?>/public/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= strtoupper($this->session->userdata('Nama')) ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     <?php $this->load->view("_template/menu") ?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
