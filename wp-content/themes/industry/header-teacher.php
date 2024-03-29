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
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="logo" href="#">LOGO</a>
            
        <ul class="profile-wrap">
            <li id="help-support-link"><a href="#">HELP/SUPPORT</a></li>
            <li>
                <span><?php echo get_user_meta(get_current_user_id(), 'first_name', true) . ' ' . get_user_meta(get_current_user_id(), 'last_name', true) ?></span>
            </li>
        </ul>
    </nav>
    <div id="wrapper">
       
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
                <li>
                    <a href="<?php echo home_url();?>/teacher"><i class="icon-dashboard-icon icon-2x"></i> DASHBOARD</a>
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
                <li>
                    <a href="#"><i class="icon-classroom-icon icon-2x"></i> RESULTS</a>
                    <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                        <li><a href="<?php echo home_url();?>/teacher/classrooms/overview"><span class="fa-stack fa-lg pull-left"></span>Classrooms</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-students-icon icon-2x"></i> PROFILE</a>
                    <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                        <li><a href="<?php echo wp_logout_url( home_url() );?>"><span class="fa-stack fa-lg pull-left"></span>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /#sidebar-wrapper -->