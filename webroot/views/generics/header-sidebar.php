<?php
    //THis array creates the sidebar links

    //die(print_r($this->session));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <!-- favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicon.ico">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
        <!-- meanmenu icon CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/meanmenu.min.css">
        <!-- main CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
        <!-- educate icon CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/educate-custon-icon.css">
        <!-- mCustomScrollbar CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- metisMenu CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/metisMenu/metisMenu.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/metisMenu/metisMenu-vertical.css">

        <?php
            if (EXTRAO == "duallist") {
                echo "<link rel='stylesheet' href='" . base_url() . "assets/css/bootstrap-duallistbox.min.css'>";
            } else if (EXTRAO == "dash") {
                echo "<link rel='stylesheet' href='" . base_url() . "assets/css/c3/c3.min.css'>";
                echo "<link rel='stylesheet' href='" . base_url() . "assets/css/calendar/fullcalendar.min.css'>";
                echo "<link rel='stylesheet' href='" . base_url() . "assets/css/calendar/fullcalendar.print.min.css'>";
            }
        ?>
        
        <!-- style CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
        <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/"> -->
        <!-- responsive CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/override.css">
        <!-- modernizr JS -->
        <script src="<?php echo base_url();?>assets/js/vendor/modernizr-2.8.3.min.js"></script>

        <?php
            // if(defined('HEADER') == "Dashboard") {
            //  echo "<link rel='stylesheet' href='" . base_url() . "assets/css/dashboard.css' type='text/css'>";
            // }
        ?>

        <title>
            <?php
                if(defined('TITLE')){       //Check if the title is set
                    print TITLE;            //If it is, then set it as the page title
                } else  {
                    print "UCCIA - Put tagline here!";      //If it's not then set a default title
                }
            ?>
        </title>
    </head>

<body>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="<?php echo base_url();?>assets/http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Start Left menu area -->
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a href="<?php echo base_url();?>dashboard"><img class="main-logo" src="<?php echo base_url();?>assets/img/logo/logo.png" alt="" /></a>
                <strong><a href="<?php echo base_url();?>dashboard"><img src="<?php echo base_url();?>assets/img/logo/logosn.png" alt="" /></a></strong>
            </div>

            <div class="left-custom-menu-adp-wrap comment-scrollbar">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                    <ul class="metismenu" id="menu1">
                        <li class="active">
                            <a class="" href="<?php echo base_url();?>dashboard">
								   <span class="mini-click-non">Dashboard</span>
							</a>
                        </li>

                        <li>
                            <a class="has-arrow" href="<?php echo base_url();?>classes/all" aria-expanded="false"><span class="mini-click-non">Classes</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All Classes" href="<?php echo base_url();?>classes/all"><span class="mini-sub-pro">All Classes</span></a></li>
                                <li><a title="Add a class" href="<?php echo base_url();?>classes/add"><span class="mini-sub-pro">Add Class</span></a></li>
                                <li><a title="Edit a class's details" href="<?php echo base_url();?>classes/edit"><span class="mini-sub-pro">Edit Class Details</span></a></li>
                                <li><a title="View class details" href="<?php echo base_url();?>classes/view"><span class="mini-sub-pro">Class Details</span></a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="<?php echo base_url();?>invigilators/all" aria-expanded="false"><span class="mini-click-non">Invigilators</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All invigilators" href="<?php echo base_url();?>invigilators/all"><span class="mini-sub-pro">All Invigilators</span></a></li>
                                <li><a title="Add an invigilator" href="<?php echo base_url();?>invigilators/add"><span class="mini-sub-pro">Add Invigilator</span></a></li>
                                <li><a title="Edit an invigilator's details" href="<?php echo base_url();?>invigilators/edit"><span class="mini-sub-pro">Edit Invigilator</span></a></li>
                                <li><a title="Invigilator's Profile" href="<?php echo base_url();?>invigilators/view"><span class="mini-sub-pro">Invigilator Profile</span></a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a class="has-arrow" href="<?php echo base_url();?>exams/all" aria-expanded="false"></span><span class="mini-click-non">Exams</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All Exams" href="<?php echo base_url();?>exams/all"><span class="mini-sub-pro">All Exams</span></a></li>
                                <li><a title="Add an exam" href="<?php echo base_url();?>exams/add"><span class="mini-sub-pro">Add Exam</span></a></li>
                                <li><a title="Edit exam details" href="<?php echo base_url();?>exams/edit"><span class="mini-sub-pro">Edit Exam</span></a></li>
                                <li><a title="Exam Details" href="<?php echo base_url();?>exams/view"><span class="mini-sub-pro">Exam Info</span></a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="<?php echo base_url();?>students/all" aria-expanded="false"><span class="mini-click-non">Students</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All Students" href="<?php echo base_url();?>students/all"><span class="mini-sub-pro">All Students</span></a></li>
                                <li><a title="Add a students" href="<?php echo base_url();?>students/add"><span class="mini-sub-pro">Add Student</span></a></li>
                                <li><a title="Edit a student's details" href="<?php echo base_url();?>students/edit"><span class="mini-sub-pro">Edit Student</span></a></li>
                                <li><a title="Student's Profile" href="<?php echo base_url();?>students/view"><span class="mini-sub-pro">Student Profile</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- End Left menu area -->
    
    <div class="all-content-wrapper">
        <div class="header-top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="header-top-wraper">
                            <div class="row">
                                <div class="col-lg-6 col-md-0 col-sm-1 col-xs-12">
                                    <div class="breadcome-list col-lg-5">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                                <div class="breadcome-heading">
                                                    <form role="search" action="<?php print base_url() . 'search' ?>" method="get" class="sr-input-func">
                                                        <input type="search" name="search_term" placeholder="Search here..." class="search-int form-control">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-5 col-sm-12 col-xs-12" style="float: right;">
                                    <div class="header-right-info">
                                        <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                            <li class="nav-item">
                                                    <a href="<?php echo base_url();?>accounts" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                        <img id="picture" class="marg-side" style="border: 3px solid white; max-width:45px;" src="<?php
                                                                                                                                //Check if there's a profile picture for the user
                                                                                                                                if(isset($this->session->picture)) {        //Show it if there is
                                                                                                                                    if (file_exists("./assets/profile/" . $this->session->picture)) {
                                                                                                                                        echo base_url() . "/assets/profile/" . $this->session->picture;
                                                                                                                                    } else {                                    //Use default if there isnt
                                                                                                                                        echo base_url() . "/assets/img/default.png"; 
                                                                                                                                    }
                                                                                                                                } else {                                    //Use default if there isnt
                                                                                                                                    echo base_url() . "/assets/img/default.png"; 
                                                                                                                                }
                                                                                                                            ?>" alt="My Profile Picture" title="My Profile Picture">

														<span class="admin-name"><?php echo $this->session->firstname . " " . $this->session->lastname; ?></span>
														<i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
													</a>

                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                        <li><a href="<?php echo base_url();?>accounts"><span class="edu-icon edu-home-admin author-log-ic"></span>My Account</a>
                                                        </li>
                                                        <li><a href="<?php echo base_url();?>logout"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid real-content">