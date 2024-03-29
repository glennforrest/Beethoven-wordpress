<?php

class FrontPage{
    
    public $template_name;
    
    public function FrontPage(){
    // Registering and Enqueing styles and scripts
		add_action( 'init', array(&$this, 'register_styles_and_scripts') );
		add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_styles_and_scripts') );
		
		//register_nav_menu('primary', __('Primary navigation', 'industry') );
		add_filter( 'wp_nav_menu_args', array(&$this, 'my_wp_nav_menu_args') );
		
		add_shortcode('svg', array(&$this, 'svg') );
		add_shortcode('contact_form', array(&$this, 'industry_contact_form') );
		
		//add_action( 'admin_enqueue_scripts', array(&$this, 'load_admin_things') );
		
		//$this->template_name= get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
	
		add_action('wp_login_failed', array(&$this, 'test') );
		
    }
   
    // public function test(){
    // 	die(var_dump('fro the functions file'));
    // }

    //[svg] Shortcode
    public function svg($atts){
    	$atts = shortcode_atts(
		array(
			'type' => $atts
		), $atts, 'svg' );
    	ob_start();
    	include 'images/svg/'.$atts['type'].'.svg';
    	return ob_get_clean();
    }
    
    // [contact_form] Shortcode
    public function industry_contact_form(){
    	ob_start();
    	include '_contact_form.php';
    	return ob_get_clean();
    }
    
    /* Removing the container div from wp_nav */
    function my_wp_nav_menu_args( $args = '' ) {
		$args['container'] = false;
		return $args;
	}
	
	public function test(){
		ob_start();
		echo 'HEY THERE';
		return ob_get_clean();
	}
    
    public function register_styles_and_scripts(){
    	
		wp_register_style('bootstrap-css', get_template_directory_uri().'/css/bootstrap.min.css', false);
		wp_register_style('core', get_template_directory_uri().'/style.css', false);
		wp_register_style('main-css', get_template_directory_uri().'/css/main.css', false);
		wp_register_style('front-page-css', get_template_directory_uri().'/css/front-page.css', false);
		wp_register_style('signup-css', get_template_directory_uri().'/css/signup.css', false);
		wp_register_style('dashboard-css', get_template_directory_uri().'/css/dashboard.css', false);
		wp_register_style('teacher-css', get_template_directory_uri().'/css/teacher.css', false);
		wp_register_style('student-css', get_template_directory_uri().'/css/student.css', false);
		wp_register_style('lesson-css', get_template_directory_uri().'/css/lesson.css', false);
		wp_register_style('plyr-css', get_template_directory_uri().'/css/plyr.css', false);
		wp_register_style('perfect-scrollbar-teacher-css', get_template_directory_uri().'/css/perfect-scrollbar-teacher.css', false);
		wp_register_style('perfect-scrollbar-student-css', get_template_directory_uri().'/css/perfect-scrollbar-student.css', false);
		
		wp_register_script('bootstrap-js', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery') );
		wp_register_script( "form-validator-js", get_template_directory_uri().'/js/form-validator.js', false);
		wp_register_script('front-page-js', get_template_directory_uri().'/js/front-page.js', false);
		wp_register_script('signup-js', get_template_directory_uri().'/js/signup.js', false);
		wp_register_script('jquery-easing', get_template_directory_uri().'/js/jquery.easing.min.js', false);
		wp_register_script('scrolling-nav', get_template_directory_uri().'/js/scrolling-nav.js', false);
		wp_register_script('waypoint', get_template_directory_uri().'/js/jquery.waypoint.min.js', false);
		wp_register_script( "login-ajax", get_template_directory_uri().'/js/login-ajax.js', false);
		wp_register_script( "app-js", get_template_directory_uri().'/js/app.js', false);
		wp_register_script( "teacher-js", get_template_directory_uri().'/js/teacher.js', false);
		wp_register_script( "lesson-js", get_template_directory_uri().'/js/lesson.js', false);
		wp_register_script( "vexflow-js", get_template_directory_uri().'/js/vexflow-min.js', false);
		wp_register_script( "chart-js", get_template_directory_uri().'/js/chart.min.js', false);
		wp_register_script( "plyr-js", get_template_directory_uri().'/js/plyr.js', false);
		wp_register_script( "perfect-scrollbar-js", get_template_directory_uri().'/js/perfect-scrollbar.jquery.js', false);
		wp_register_script( "dashboard-js", get_template_directory_uri().'/js/dashboard.js', false);
		wp_register_script( "student-js", get_template_directory_uri().'/js/student.js', false);
		
	}
	
	public function enqueue_styles_and_scripts() {
		
		
		//die(var_dump($this->template_name));
		
		wp_enqueue_style('bootstrap-css');
		wp_enqueue_style('core');
		wp_enqueue_style('main-css');
		// If front page, loading front page specific styles
		
		if(is_front_page() || is_page('about-us' || is_page('signup')) ){
		    wp_enqueue_style('front-page-css');
		    wp_enqueue_script('form-validator-js');
		}
		
		
		
		wp_enqueue_script('bootstrap-js');
		
		if(is_page('signup')){
			wp_enqueue_style('signup-css');
			wp_enqueue_script('signup-js');
		}
		
		if(is_front_page()){
		    wp_enqueue_style('plyr-css');
		    wp_enqueue_script('plyr-js');
		    wp_enqueue_script('front-page-js');
		    wp_enqueue_script('jquery-easing');
		    wp_enqueue_script('scrolling-nav');
		    wp_enqueue_script('waypoint');
		    
		    
   			wp_localize_script( 'login-ajax', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   			wp_enqueue_script('login-ajax');
		    
		}
		
		if(!is_front_page()){
			wp_enqueue_script('app-js');
		}
		
		if(is_page_template('teacher.php') || is_page_template('student.php') ){
			wp_enqueue_style('dashboard-css');
			
			wp_enqueue_script('dashboard-js');
			wp_enqueue_script('perfect-scrollbar-js');
			wp_enqueue_script('chart-js');
			wp_enqueue_script('form-validator-js');
			
			// Loading media upload support
			wp_enqueue_script('media-upload');
		    wp_enqueue_script('thickbox');
		    wp_enqueue_style('thickbox');
		    
		    
		}
		
		if(is_page_template('teacher.php')){
			wp_enqueue_style('teacher-css');
			wp_enqueue_style('perfect-scrollbar-teacher-css');
			wp_enqueue_script('teacher-js');
		}
		
		if(is_page_template('student.php')){
			wp_enqueue_style('student-css');
			wp_enqueue_style('perfect-scrollbar-student-css');
			wp_enqueue_script('student-js');
		}
		
		if(is_page_template('lesson.php')){
			
			wp_enqueue_style('plyr-css');
			wp_enqueue_style('lesson-css');
			wp_enqueue_script('vexflow-js');
			wp_enqueue_script('plyr-js');
    		wp_enqueue_script('lesson-js');
    		
    		
		}
		
		
		
	}	
	
}

$frontPage = new FrontPage();

include('_teacher_functions.php');

include('_student_functions.php');

include('_register_functions.php');

?>