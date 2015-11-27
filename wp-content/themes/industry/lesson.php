<?php

/**
* Template Name: Secure Lesson Area
**/

// If statement here checking whether the user has correct permissions, if so do the loop
if($current_user->roles[0] === 'student' || $current_user->roles[0] === 'administrator'){

    // Call to the header for the teacher    
    get_header('lesson');

    // Call for the loop for teacher's dashboard.
    // Similar way to the front-page where it takes 
    // the wp_options array and loads in the 'modules'
    ?>
            <?php 
                        // Checking that there are posts
                        if ( have_posts() ) : 
                            // Start the loop.
                            while ( have_posts() ) : the_post();
                                echo the_content();
                                // End the loop.
                            endwhile;
                        // If no content, include the "No posts found" template.
                        else :
                            echo 'Uh oh, nothing fooooooooooound.';
                            echo is_single();
                        endif;
    		    ?></div>
            </div>
        </div>
    </div>
    <?php
    
    // Call to the footer for the teacher
    get_footer('lesson');
    
}else{
    // Otherwise they don't have permissions to be here.
    // Need to display a message somewhere..
    wp_redirect( home_url() );
    exit;
}