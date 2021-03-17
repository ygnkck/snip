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


/***** add ACF options page **********/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

/****** disable gutenberg ******/

add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type)
{
    
    if ($post_type === 'services' || $post_type === 'projects' ) return false;
	
    return $current_status;
}
