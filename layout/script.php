<?php

error_reporting(E_ALL);

// Alterar essa linha para refletir a sua estrutura de pastas:

$url = 'http://localhost/premier_salgados/views/';

// Loading navigation menu:

$userType = ($perm == '1') ? 'Administrador' : 'Vendedor';

$head = '<!DOCTYPE html>
<html>
<head>
  <style>
  div.error{
    color: red;
    border: 1px solid transparent;
    margin-top: 5px;
  }
  </style>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="content-language" content="pt-br" /> 
  <title>Premier Salgados</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="' . $url . 'bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="' . $url . 'dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="' . $url . 'dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="' . $url . 'plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="' . $url . 'plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="' . $url . 'plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="' . $url . 'plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="' . $url . 'plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="' . $url . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <script src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
  
  <script type="text/javascript">
    $(document).ready(function(){
    $("input[name=\'status[]\']").click(function(){
      var $this = $( this );//guardando o ponteiro em uma variavel, por performance


      var status = $this.attr(\'checked\') ? 1 : 0;
      var id = $this.next(\'input\').val();


      $.ajax({
        url: \'action.php\',
        type: \'GET\',
        data: \'status=\'+status+\'&id=\'+id,
        success: function( data ){
          alert( data );
        }
      });
    });
  }); 
  </script>
  
<!-- Lista Cliente CPF -->

<script type="text/javascript">
 
 $(document).ready(function(){  
      $(\'#cpfCliente\').keyup(function(){  
           var query = $(this).val();  
           if(query != "")  
           {  
                $.ajax({  
                     url:"' . $url . '../App/Database/search.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          
                          $(\'#Listdata\').fadeIn();  
                          $(\'#Listdata\').html(data);  
                     }  
                });  
           }  
      });  


      $(\'#Listdata\').on("click","li", function(){  
           $(\'#cpfCliente\').val($(this).text());  
           $(\'#Listdata\').fadeOut();
           <!-- console.log(event.target);-->
      });
  });  
 </script>

 <!-- FIM Lista Cliente CPF --> 

 <!-- Consulta Qtd venda -->

<script type="text/javascript">

 $(document).ready(function(){

      $("#prodSubmit").click(function()  {

        var prodSubmit = $("#prodSubmit").val();
        var idItem = $("#idItem").val();
        var qtd = $("#qtd").val();
        
        $.ajax({
          type: "POST",
          url: "' . $url . '../App/Database/carrinho.php",
          data: {prodSubmit: prodSubmit, idItem: idItem, qtd:qtd},
          success: function(data){
            $(\'#listable\').fadeIn();  
            $(\'#listable\').html(data);
          },
          error: function(data){
            alert(data);
          }
        });
      }); 

    $(\'#listable\').on("click","li", function(){  
           $(\'#idItem\').val($(data).text());
           $(\'#qtd\').val($(data).text());  
           $(\'#listable\').fadeOut();
          
            return false;

           <!-- console.log(event.target);-->
      });           
            
    
 });  
 </script>

 <script type="text/javascript">
(function ($) {

    RemoveTableRow = function (handler) {
        var tr = $(handler).closest(\'tr\');

        tr.fadeOut(400, function () {
            tr.remove();
        });

        return false;
    };

    AddTableRow = function () {

        var newRow = $("<tr>");
        var cols = \'<td></td>\';
        var tabela = document.getElementById(\'products-table\');
        var a = (tabela.getElementsByTagName(\'tr\'));
        var b = a.length;
        var i = b - 2;
        var cont = 7 + i;

        cols += \'<td><input type="text" class="form-control" id="idItem" name="idItem[]" autocomplete="off" /></td>\';
        cols += \'<td><input type="text" class="form-control" id="qtd" name="qtd[]" autocomplete="off" /><span id="stv" name="stv[]"></span></td>\';
        cols += \'<td class="actions">\';
        cols += \'<button class="btn btn-danger btn-xs" onclick="RemoveTableRow(this)" type="button"><i class="fa fa-trash"></i></button>\';
        cols += \'</td>\';

        newRow.append(cols);
        $("#products-table").append(newRow);
        return false;
    };


})(jQuery);
</script>

<!-- Consulta Qtd Vendas -->

  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">';

$header = '<header class="main-header">
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Premier</b>Salgados</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Premier</b>Salgados</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      
        <span class="sr-only">Toggle navigation</span>
      </a>
	  
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->

          <li style="padding: 5px">
            <img src="' . $foto . '" class="img-circle left" style="width:40px;display:block;" />
          </li>
          <li class="dropdown messages-menu">
            <a style="display:block;" href="#" class="left dropdown-toggle" data-toggle="dropdown">
              <url=' . $url . '>
              <span class="hidden-xs">' . $usuario . ' (' . $userType . ')</span>
            </a>
          </li>
          <li>
            <a href="' . $url . 'destroy.php" class="btn btn-danger">Sair</a>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>';

ob_start();

echo '<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">';
include(__DIR__ . '/navigation.php');
echo '</section>
    <!-- /.sidebar -->
  </aside>';

$aside = ob_get_contents();

ob_end_clean();

$footer = '<footer class="main-footer"> </footer>

 
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>';

$javascript = '

  </div>
<!-- jQuery 2.2.3 -->
<script src="' . $url . 'plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="' . $url . 'bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="' . $url . 'dist/js/validate-custom.min.js"></script>
<script src="' . $url . 'dist/js/inputmask.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  jQuery.validator.addMethod("data", function (value, element){
    return this.optional( element ) || /([0-9]{2})(\/)([0-9]{2})(\/)([0-9]{4})/.test( value );
  }, "Digite uma data válida!");

  jQuery.validator.addMethod("price", function (value, element){
    return this.optional( element ) || /([0-9\.\,]{2,})/.test( value );
  }, "Digite um preço válido!");

  $("#cpf").inputmask({"mask": "999.999.999-99", "placeholder": " "});
  $(".data").inputmask({"mask": "99/99/9999", "placeholder": " "});

  $("#new-prod").validate({errorElement: "div"});

  $("#new-item").validate({errorElement: "div", rules: {
    QuantItens: {
      required: true,
      digits: true,
    },
    ValCompItens: {
      required: true,
      price: true,
    },
    ValVendItens: {
      required: true,
      price: true,
    },
    DataCompraItens: {
      required: true,
      data: true,
    },
    DataVenci_Itens: {
      data: true,
    }
  }, messages: {QuantItens: {digits: "Digite somente números"}}});
})
</script>
<script src="' . $url . 'plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="' . $url . 'plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="' . $url . 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="' . $url . 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="' . $url . 'plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="' . $url . 'plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="' . $url . 'plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="' . $url . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="' . $url . 'plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="' . $url . 'plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="' . $url . 'dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="' . $url . 'dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="' . $url . 'dist/js/demo.js"></script>

</body>
</html>
';
