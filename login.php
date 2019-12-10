<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Premier Salgados</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="views/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="views/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
  div.error{
    color: red;
    margin-top: 5px;
    border: 1px solid transparent;
  }
  </style>
  <?php
    require 'App/Helpers/ValidationSession.php';
    $vSession = new ValidationSession('login-validation');
    $vSession->setErrorContainer('<div class="error">{error}</div>');
   ?>
</head>

<body class="hold-transition login-page">

  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Premier </b>Salgados</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Digite Usuário e a Senha</p>

      <form action="App/session.php" method="post" id="login-form">
        <div class="form-group has-feedback">
          <input type="text" <?php echo $vSession->getValue('username'); ?> name="username" required class="form-control" placeholder="Nome">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          <?php echo $vSession->getErrors('username'); ?>
        </div>
        <div class="form-group has-feedback">
          <input type="password" <?php echo $vSession->getValue('password'); ?> name="password" required class="form-control" placeholder="Senha">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          <?php echo $vSession->getErrors('password'); ?>
        </div>

        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
          </div>
        </div>

      </form>
      <!-- /.col -->
      <!-- jQuery 2.2.3 -->
      <script src="views/plugins/jQuery/jquery-2.2.3.min.js"></script>
      <!-- Bootstrap 3.3.6 -->
      <script src="views/bootstrap/js/bootstrap.min.js"></script>
      <!-- iCheck -->
      <script src="views/plugins/iCheck/icheck.min.js"></script>
      <!-- jQuery Validator -->
      <script src="views/dist/js/validate-custom.min.js"></script>
      <script>
        $(function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          });

          // validation:

          $('#login-form').validate({
            errorElement: "div",
            rules: {
              username: {
                required: true,
              },
              password: {
                required: true,
              }
            },
          });
        });
      </script>
</body>

</html>