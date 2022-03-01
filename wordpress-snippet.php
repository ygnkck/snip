<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */


/**********custom post type , custom loop on custom page template *************/




	global $post;
	$args = array(
	'post_type' => 'sdg-portfolio',
	'post_status' => 'publish',
	'posts_per_page'=> 9,
	);	
	$pl_query = new WP_Query($args);					
	$count = 0; 
	$delay = 100;
        $total_posts = $pl_query->post_count;	


	if($pl_query->have_posts()): while($pl_query->have_posts()): $pl_query->the_post();  


	$catinfo = get_category();


	print_r($catinfo);

	
	endwhile; endif; 


/***** add ACF options page **********/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}


<---- or --->

add_action('acf/init', 'cs_acf_op_init');
function cs_acf_op_init() {

    if( function_exists('acf_add_options_page') ) {

        $option_page = acf_add_options_page(array(
            'page_title'    => __('Etrux General Settings'),
            'menu_title'    => __('Etrux Settings'),
            'menu_slug'     => 'etrux-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}



/****** disable gutenberg for all post type ******/

add_filter( 'use_block_editor_for_post', '__return_false' );

/****** disable gutenberg for specific post type ******/

add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type)
{
    
    if ($post_type === 'services' || $post_type === 'projects' ) return false;
	
    return $current_status;
}

/******* Wordpress breadcrumbs **********/ 

function the_breadcrumb() {

    $sep = ' > ';

    if (!is_front_page()) {
	
	// Start the breadcrumb with a link to your homepage
        echo '<div class="breadcrumbs">';
        echo '<a href="';
        echo get_option('home');
        echo '">';
        bloginfo('name');
        echo '</a>' . $sep;
	
	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        if (is_category() || is_single() ){
            the_category('title_li=');
        } elseif (is_archive() || is_single()){
            if ( is_day() ) {
                printf( __( '%s', 'text_domain' ), get_the_date() );
            } elseif ( is_month() ) {
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
            } elseif ( is_year() ) {
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
            } else {
                _e( 'Blog Archives', 'text_domain' );
            }
        }
	
	// If the current page is a single post, show its title with the separator
        if (is_single()) {
            echo $sep;
            the_title();
        }
	
	// If the current page is a static page, show its title.
        if (is_page()) {
            echo the_title();
        }
	
	// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        if (is_home()){
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) { 
                $post = get_page($page_for_posts_id);
                setup_postdata($post);
                the_title();
                rewind_posts();
            }
        }

        echo '</div>';
    }
}

