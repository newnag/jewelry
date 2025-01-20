<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thavorn Jewelry Management System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/plugins/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body class="hold-transition sidebar-mini">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="/asset/img/logo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php
        $url = explode('/',$_SERVER['REQUEST_URI']) ;
        // print_r($url);
    ?>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand <?php if($url[1] == 'stock-gold'){echo 'head-gold';}elseif($url[1] == 'member'){echo 'head-member';}elseif($url[1] == 'stock-gold-rental'){echo 'head-gold';}?>">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="<?php if($url[1] == 'stock-gold'){echo 'color: #d9a82a';}?>"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block"></li>
                <a href="../dashboard" class="nav-link" style="<?php if($url[1] == 'stock-gold'){echo 'color: #d9a82a';}?>">หน้าหลัก</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <style>
        .logout-btn{
            position : absolute;
            right: 10px;
        }
        </style>
        <?php
            if($url[1] == 'stock-gold'){
                echo '
                    <div class="logout-btn"><button type="button" class="btn btn-sm btn-block" style="background: #d9a82a;color: #951b1e;" onclick="logout()">ออกจากระบบ</button></div>
                ';
            }
            elseif($url[1] == 'member'){
                echo '
                    <div class="logout-btn"><button type="button" class="btn btn-sm btn-block" style="background: #fff;color: #68a8a7;" onclick="logout()">ออกจากระบบ</button></div>
                ';
            }
            elseif($url[1] == 'stock-jewelry'){
                echo '
                    <div class="logout-btn"><button type="button" class="btn btn-sm btn-block" style="background: #fff;color: #68a8a7;" onclick="logout()">ออกจากระบบ</button></div>
                ';
            }
            elseif($url[1] == 'stock-gold-rental'){
                echo '
                    <div class="logout-btn"><button type="button" class="btn btn-sm btn-block" style="background: #fff;color: #68a8a7;" onclick="logout()">ออกจากระบบ</button></div>
                ';
            }
        ?>
        
    </nav>
    <!-- /.navbar -->