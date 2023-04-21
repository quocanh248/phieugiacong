    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Việt Trần | Trang chủ</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
                       <!-- Google Font: Source Sans Pro -->
        
     
        <!-- Tempusdominus Bootstrap 4 -->
   
        <!-- JQVMap -->
      
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
      
       
       


    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
          
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
               

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <?php
                  $userid = Session::get('userid' );                  
                  if(!empty($userid)) {?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" onclick="dangxuat()">
                           Đăng xuât
                            {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
                        </a>

                    </li>
                    <?php
                  }else{                 
                  
                  ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="login">
                            <i class="fa-solid fa-lock"></i>Đăng nhập
                            {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
                        </a>

                    </li>
                    <?php }?>

                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="" class="brand-link">
                    <img src="/dist/img/logoviettran.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">Việt Trần Admin</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        {{-- <div class="image">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">Alexander Pierce</a>
                        </div> --}}
                    </div>

                
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">                          
                            <li class="nav-item menu-open">
                                <a href="/quetqr" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        TLR

                                    </p>
                                </a>
                            </li>
                         
                            <?php
                            $q = Session::get('quyen' );                  
                            if(!empty($userid) || $q ==1) {?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        Model
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-info right">4</span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/dsmodel" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh sách Model</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/viewthemmodel" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Thêm bằng tay</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/viewthemmodelecxel" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Thêm Model bằng excel</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/xemlsquet" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lịch sử quét</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        ASSY
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-info right">4</span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/dsassy" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh sách ASSY</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/themassybangtay" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Thêm ASSY bằng tay</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/viewthemassyecxel" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Thêm ASSY bằng Excel</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/xemlsquetassy" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lịch sử quét ASSY</p>
                                        </a>
                                    </li>

                                    
                                </ul>
                            </li>
                            <?php
                            }
                            ?>                           
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
              
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="/plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        {{-- <script src="/plugins/sparklines/sparkline.js"></script> --}}
        <!-- JQVMap -->
        {{-- <script src="/plugins/jqvmap/jquery.vmap.min.js"></script> --}}
        {{-- <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
        <!-- jQuery Knob Chart -->
        <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="/plugins/moment/moment.min.js"></script>
        <script src="/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/adminlte.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/dist/js/demo.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="/dist/js/pages/dashboard.js"></script>
        @include('sweetalert::alert')
        <script type="text/javascript">
            function dangxuat() {
                if (confirm('Bạn có chắc muốn đăng xuất?')) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        processData: false,
                        contentType: false,
                        type: 'GET',
                        dataType: 'JSON',
                        url: '/dangxuat',
                        success: function(res) {
                            //window.location.href = window.location.href;
                        }
                    });
                }
                window.location.reload();
            }
        </script>
    </body>

    </html>
