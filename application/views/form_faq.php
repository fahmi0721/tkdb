
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title_page; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= base_url() ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/public/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('public/css/datepicker3.css') ?>">
  <link rel="stylesheet" href="<?= base_url() ?>/public/css/AdminLTE.min.css">
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>FAQ</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Apa kendala anda?</p>
    <?php if($this->session->flashdata('success') == TRUE): ?>
    <div role='alert' class="alert alert-success alert-dismissible fade in">
      <button aria-lable='Close' data-dismiss="alert" class='close' type='button'><span aria-hidden='true' class='fa fa-times'></span></button>
      <p><?= $this->session->flashdata('success') ?></p>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error') == TRUE): ?>
    <div role='alert' class="alert alert-danger alert-dismissible fade in">
      <button aria-lable='Close' data-dismiss="alert" class='close' type='button'><span aria-hidden='true' class='fa fa-times'></span></button>
      <p><?= $this->session->flashdata('error') ?></p>
    </div>
    <?php endif; ?>
    <form action="<?= base_url("faq/proses") ?>" method="post" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" autocomplete=off name="Noktp" data-toggle='tooltip' title='masukkan No KTP Anda ' placeholder="No KTP" required>
        <span class="form-control-feedback" ></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" autocomplete=off name="Nama" data-toggle='tooltip' title='masukkan Nama Lengkap Anda ' placeholder="Nama Lengkap" required>
        <span class="form-control-feedback" ></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" autocomplete=off name="TglLahir" id="TglLahir" data-toggle='tooltip' title='masukkan Tanggal Lahir Anda ' placeholder="Tanggal Lahir" required>
        <span class="form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" autocomplete=off name="NoHp" data-toggle='tooltip' title='masukkan Nomor Whatsapp Anda ' placeholder="No WA" required>
        <span class="form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="file" accept=".jpg,.jpeg,.png" class="form-control" autocomplete=off name="Files" data-toggle='tooltip' title='masukkan Foto Ktp Anda ' placeholder="Foto KTP" required>
        <span class="form-control-feedback" ></span>
      </div>

      <div class="form-group has-feedback">
        <textarea rows='5' class="form-control" autocomplete=off name="Keterangan" data-toggle='tooltip' title='masukkan Foto Ktp Anda ' placeholder="Apa kendala anda?" required></textarea>
        <span class="form-control-feedback" ></span>
      </div>
      

      <div class="form-group">
        <span class="pull-right">
        <a href="<?= base_url("auths") ?>" class="btn btn-danger btn-flat" type='button'  name="login"><i class="fa fa-sign-in"></i> LOGIN</a>
        <button class="btn btn-primary btn-flat" type='submit'  name="login"><i class="fa fa-check-square"></i> KIRIM</button></span>
        <span class="clearfix"></span>
      </div>

    </form>
   
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url() ?>/public/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url() ?>/public/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>/public/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function(){
      $("#TglLahir").datepicker({ "format": "yyyy-mm-dd", "autoclose": true,changeMonth: true,changeYear: true });
      $("[data-toggle='tooltip']").tooltip();
    })
</script>
</body>
</html>
