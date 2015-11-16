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


<body id="home">
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                   <a class="navbar-brand" href="/">Home</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        
                        <?php 
                        /* First args defines the menu
                           Second arg removes wrapping Ul element */
                            $args = array(
                                'menu' => 'Primary navigation',
                                'items_wrap' => '%3$s');
                            
                            wp_nav_menu($args);
                        ?>
                            
                      
                        <li><a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
                            <div class="dropdown-menu" id="login-box">
                              <form id="login-form" method="post" accept-charset="UTF-8">
                                    <div class="form-group">
                                        <input id="username" class="form-control" type="text" name="login[username]" size="30" placeholder="Email" />
                                    </div>
                                    <div class="form-group">
                                        <input id="password" class="form-control" type="password" name="login[password]" size="30" placeholder="Password" />
                                    </div>
                                    <input class="btn btn-default" type="submit" name="submit" value="Login" />
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>    
            </div>
        </nav>
    