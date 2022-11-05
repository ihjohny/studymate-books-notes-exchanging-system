<!DOCTYPE html>
<html lang="en">

<?php

include('class/DbData.php');

$object = new DbData;

if (!$object->is_login()) {
    header("location:" . "/");
}

if($object->isUserBlocked($_SESSION['user_id'])) {
    header("location:" . "logout.php");
}

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NSTU StudyMate - <?php echo $object->project_title?></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/fontawesome-free/css/v4-shims.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="vendor/parsley/parsley.css" />

    <link rel="stylesheet" type="text/css" href="vendor/bootstrap-select/bootstrap-select.min.css" />

    <link rel="stylesheet" type="text/css" href="vendor/datepicker/bootstrap-datepicker.css" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <i class="fas fa-book-open"></i>
                <div class="sidebar-brand-text mx-3">NSTU StudyMate</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-home"></i>
                    <span>Home</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donateposts.php">
                    <i class="fas fa-upload"></i>
                    <span>Donate/Loan Posts</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="requestposts.php">
                    <i class="fas fa-download"></i>
                    <span>Request Posts</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="myposts.php">
                    <i class="fas fa-book"></i>
                    <span>My Posts</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="category_subscriptions.php">
                    <i class="fas fa-star"></i>
                    <span>Category Subscriptions</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="keyword_subscriptions.php">
                    <i class="fas fa-keyboard"></i>
                    <span>Keyword Subscriptions</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="history.php">
                    <i class="fas fa-history"></i>
                    <span>History</span></a>
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
                        <h3><?php echo $object->project_title?></h3>
                    </div>

                    <!-- Topbar Navbar -->

                    <?php
                    $user_name = '';
                    $user_profile_img = '';
                    $point = '';
                    $point_color = 'success';

                    $object->query = "
                    SELECT * FROM users 
                    WHERE id = '" . $_SESSION['user_id'] . "'
                    ";

                    $user_result = $object->get_result();

                    foreach ($user_result as $row) {
                        $user_name = $row['name'];
                        $user_profile_img = $row['photo'];
                        $point = $row['point'];
                        if ($point < 1) {
                            $point_color = 'danger';
                        }
                    }
                    ?>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <button class="btn btn-outline-<?php echo $point_color; ?> btn-sm">Points: <?php echo $point; ?></button>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <span class="dropdown-item">+2 Points for Registration</span>
                                <span class="dropdown-item">+1 Point for Successful Donate/Loan</span>
                                <span class="dropdown-item">-1 Point for Successful Request</span>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="user_profile_name"><?php echo $user_name; ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo $user_profile_img; ?>" id="user_profile_image">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">