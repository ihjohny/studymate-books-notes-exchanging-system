<!DOCTYPE html>

<html lang="en">

<?php

include('../class/DbData.php');

$object = new DbData;

if (!$object->is_admin_login()) {
    header("location:" . "/");
}

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Studymate Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap-select/bootstrap-select.min.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/datepicker/bootstrap-datepicker.css" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <i class="fas fa-user-cog"></i>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-clipboard"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-users"></i>
                    <span>Users List</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="post.php">
                    <i class="fas fa-database"></i>
                    <span>Posts List</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="category.php">
                    <i class="fas fa-tablets"></i>
                    <span>Categories List</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="department.php">
                    <i class="fas fa-school"></i>
                    <span>Departments List</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="text-center">
                        <h2>Studymate</h2>
                    </div>

                    <!-- Topbar Navbar -->

                    <?php
                    $admin_name = '';

                    $object->query = "
                    SELECT * FROM admins 
                    WHERE id = '" . $_SESSION['admin_id'] . "'
                    ";

                    $admin_result = $object->get_result();

                    foreach ($admin_result as $row) {
                        $admin_name = $row['name'];
                    }
                    ?>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="modal" data-target="#logoutModal">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin_name; ?></span>
                                <i class="fas fa-power-off"></i>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                