/ disable guternberg for posts
add_filter('use_block_editor_for_post', '__return_false', 10);

// disable guternberg for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

//add optoin page
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

/**
 * Enqueue scripts and styles.
 */
function cs_etrux_scripts() {
	
	wp_register_style( 'theme-style', get_template_directory_uri() . '/css/theme_style.css' );
	wp_enqueue_style( 'theme-style' );
	
	wp_register_style( 'swiper', get_template_directory_uri() . '/css/swiper-bundle.min.css' );
	wp_enqueue_style( 'swiper' );
	
	wp_register_script( 'swiper', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), '', true );
	wp_enqueue_script( 'swiper');
	
	wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array(), '', true );
	wp_enqueue_script( 'main');
	

}
add_action( 'wp_enqueue_scripts', 'cs_etrux_scripts' );

// Allow SVG Start
function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');
// Allow SVG End

//Add class in menu li
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'ex__site-link text-white xlarge-title font-secondry'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}

/** Create Footer widgets start */
function footer_section1_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Footer Section 1' ),
        'id' => 'footer-section-1',
        'before_widget' => '<div class="ex__footer-col">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
	) );
	register_sidebar( array(
        'name' => __( 'Footer Section 2' ),
        'id' => 'footer-section-2',
        'before_widget' => '<div class="ex__footer-col">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
	) );
	register_sidebar( array(
        'name' => __( 'Footer Section 3' ),
        'id' => 'footer-section-3',
        'before_widget' => '<div class="ex__footer-col">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
	) );
	register_sidebar( array(
        'name' => __( 'Footer Section 4' ),
        'id' => 'footer-section-4',
        'before_widget' => '<div class="ex__footer-col">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
	) );
	register_sidebar( array(
        'name' => __( 'Footer Section 5' ),
        'id' => 'footer-section-5',
        'before_widget' => '<div class="ex__footer-col">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'footer_section1_widgets_init' );
/** Create Footer widgets end */
