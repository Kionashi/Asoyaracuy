<!DOCTYPE html>
<html>
<head>
    @include('templates.admin.master.head')
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        @include('templates.admin.master.header')
    </header>
  <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('templates.admin.master.sidebar')
  </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('templates.admin.master.breadcrumbs')
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @include('templates.admin.master.footer')
    </footer>
  <div class="control-sidebar-bg"></div>
</div>
@include('templates.admin.master.script')
@yield('custom_script')
<script type="text/javascript">
    $(document).ready(function(){
        var validator = $('form').validate();
        $('select').change(function(){
            validator.element($(this));
        });
        $('input').change(function(){
            validator.element($(this));
        });
        $('textarea').change(function(){
            validator.element($(this));
        });
        
        // Hide empty menu groups
        $('li.treeview').each(function( index ) {
            if ($(this).find('ul.treeview-menu li').length == 0)
                $(this).remove();
        });
    });
</script>
</body>
</html>
