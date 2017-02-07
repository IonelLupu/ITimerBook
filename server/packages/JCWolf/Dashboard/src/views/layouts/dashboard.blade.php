<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title or 'Admin' }} Dashboard</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
{!!  Html::style("/dashboard/bootstrap/css/bootstrap.min.css") !!}
<!-- Font Awesome -->
{!!  Html::style("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css") !!}
<!-- Ionicons -->
{!!  Html::style("https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css") !!}

@yield('topAssets')

<!-- Theme style -->
{!!  Html::style("/dashboard/dist/css/AdminLTE.css") !!}
<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
{!!  Html::style("/dashboard/dist/css/skins/_all-skins.min.css") !!}
<!-- iCheck -->
{!!  Html::style("/dashboard/plugins/iCheck/flat/blue.css") !!}
<!-- Morris chart -->
{!!  Html::style("/dashboard/plugins/morris/morris.css") !!}
<!-- jvectormap -->
{!!  Html::style("/dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.css") !!}
<!-- Date Picker -->
{!!  Html::style("/dashboard/plugins/datepicker/datepicker3.css") !!}
<!-- Daterange picker -->
{!!  Html::style("/dashboard/plugins/daterangepicker/daterangepicker.css") !!}
<!-- bootstrap wysihtml5 - text editor -->
{!!  Html::style("/dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") !!}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!!  Html::script("https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js") !!}
    {!!  Html::script("https://oss.maxcdn.com/respond/1.4.2/respond.min.js") !!}
    <![endif]-->


    <!-- jQuery 2.2.3 -->
{!!  Html::script("/dashboard/plugins/jQuery/jquery-2.2.3.min.js") !!}
<!-- jQuery UI 1.11.4 -->
{!!  Html::script("https://code.jquery.com/ui/1.11.4/jquery-ui.min.js") !!}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge( 'uibutton', $.ui.button );
    </script>
    <!-- Bootstrap 3.3.6 -->
{!!  Html::script("/dashboard/bootstrap/js/bootstrap.min.js") !!}
<!-- Morris.js charts -->
{!!  Html::script("https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js") !!}
{!!  Html::script("/dashboard/plugins/morris/morris.min.js") !!}
<!-- Sparkline -->
{!!  Html::script("/dashboard/plugins/sparkline/jquery.sparkline.min.js") !!}
<!-- jvectormap -->
{!!  Html::script("/dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") !!}
{!!  Html::script("/dashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") !!}
<!-- jQuery Knob Chart -->
{!!  Html::script("/dashboard/plugins/knob/jquery.knob.js") !!}
<!-- daterangepicker -->
{!!  Html::script("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js") !!}
{!!  Html::script("/dashboard/plugins/daterangepicker/daterangepicker.js") !!}
<!-- datepicker -->
{!!  Html::script("/dashboard/plugins/datepicker/bootstrap-datepicker.js") !!}
<!-- Bootstrap WYSIHTML5 -->
{!!  Html::script("/dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") !!}
<!-- Slimscroll -->
{!!  Html::script("/dashboard/plugins/slimScroll/jquery.slimscroll.min.js") !!}
<!-- FastClick -->
    {!!  Html::script("/dashboard/plugins/fastclick/fastclick.js") !!}


</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    @include('Dashboard::partials.header')

    @include('Dashboard::partials.menu')

    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('Dashboard::partials.footer')
    @include('Dashboard::partials.sidebar')
</div>

<!-- AdminLTE App -->
{!!  Html::script("/dashboard/dist/js/app.min.js") !!}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{!!  Html::script("/dashboard/dist/js/pages/dashboard.js") !!}
<!-- AdminLTE for demo purposes -->
{!!  Html::script("/dashboard/dist/js/demo.js") !!}

@yield('assets')

</body>
</html>