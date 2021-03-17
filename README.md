

/********* disable gutenberg for custom post types ********/



add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);

function prefix_disable_gutenberg($current_status, $post_type)
{
    
    if ($post_type === 'services' || $post_type === 'projects' ) return false;
	
    return $current_status;
}
