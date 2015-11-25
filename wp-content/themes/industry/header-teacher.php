<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title(); ?></title>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <!-- wp_head() START -->
    <?php wp_head();?>
    <!-- wp_head() FINISH -->
</head>

<body>
   
    <nav class="navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header fixed-brand">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">LOGO</a>
            
        </div><!-- navbar-header-->
        <ul class="nav navbar-nav pull-right">
                <li><a href="#">HELP/SUPPORT</a></li>
                <li><img id="profile-image" src="https://placehold.it/48x48"></img><a class="dropdown-toggle" href="#" data-toggle="dropdown">EDDIE DEAN<strong class="caret"></strong></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo wp_logout_url( home_url() );?>">Logout</a>
                    </div>
                </li>
            </ul>
    </nav>
    <div id="wrapper">
       
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
                <li class="active">
                    <a href="/dashboard"><i class="icon-dashboard-icon icon-2x"></i> DASHBOARD</a>
                </li>
                <li>
                    <a href="#"><i class="icon-classroom-icon icon-2x"></i> CLASSROOMS</a>
                    <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                        <li><a href="<?php echo home_url();?>/teacher/classrooms/overview"><span class="fa-stack fa-lg pull-left"></span>Overview</a></li>
                        <li><a href="<?php echo home_url();?>/teacher/classrooms"><span class="fa-stack fa-lg pull-left"></span>Add New</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-students-icon icon-2x"></i> STUDENTS</a>
                    <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                        <li><a href="<?php echo home_url();?>/teacher/student/overview"><span class="fa-stack fa-lg pull-left"></span>Overview</a></li>
                        <li><a href="<?php echo home_url();?>/teacher/student"><span class="fa-stack fa-lg pull-left"></span>Add New</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-lessons-icon icon-2x"></i> LESSONS</a>
                    <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                        <li><a href="<?php echo home_url();?>/teacher/lesson/overview"><span class="fa-stack fa-lg pull-left"></span>Overview</a></li>
                        <li><a href="<?php echo home_url();?>/teacher/lesson"><span class="fa-stack fa-lg pull-left"></span>Add New</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /#sidebar-wrapper -->