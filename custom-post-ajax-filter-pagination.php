
/**** file : page-movies.php **************************************/ 
<?php
/*
* Template Name:Movies page
*
*/

get_header();




$genres = get_terms(
array(
    'taxonomy' => 'genre',
    'hide_empty' => false,
));

 ?>
<div class="movies_content">
<div class="container">

<ul>
<li class="genre" data-genre="all" >All</li>
<?php

foreach ($genres as $genre ){

?>

<li class="genre" data-genre="<?php echo $genre->slug;?>" ><?php echo $genre->name;?></li>

<?php		

}
?>
</ul>
</div>

<div id="loading">
<div class="container">
<ul>
<li>Loading........	</li>
</ul>
</div>
</div>
<div class="movie-list">

<div class="container">

<ul>

<?php 

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = array(  
        'post_type' => 'movies',
        'post_status' => 'publish',
        'posts_per_page' => 1,
		'paged' => $paged,
    
    );

  $loop = new WP_Query( $args );
  
  while ( $loop->have_posts() ) : $loop->the_post(); 
  
	
	$genre = get_the_terms(get_the_ID(),'genre');
	

?>

<li>
	<h3><?php the_title();?></h3>
		<?php foreach($genre as $gen ){ ?>
		<span><?php echo $gen->name; ?></span>
		
		<?php } ?>
		
	<p><?php the_content();?></p>
</li>

<?php endwhile; ?>

</ul>
 
<div class = "news-list-pagination" >
 
<?php


$total_pages = $loop -> max_num_pages;
 
if ($total_pages > 1) {
 
    $current_page = max(1, get_query_var('paged'));
 
    echo paginate_links(array(
        'base' => get_pagenum_link(1).
        '%_%',
        //'format' => '/page/%#%',
        'current' => $current_page,
        'total' => $total_pages,
        'prev_text' => __('<< Pre'),
        'next_text' => __('Next >>'),
	
    ));
} ?>
 
<?php wp_reset_postdata(); ?>
 
</div>

</div>
</div>

</div>

<?php
get_footer(); ?>

/**** end  file : page-movies.php **************************************/ 



/************ start file : front-end.js *****************************/
<script>
(function($) {
    jQuery(document).ready(function() {
        var cat_buttons = jQuery("li.genre");
        cat_buttons.on( 'click', function(event){
            // 
            event.preventDefault();
			
			jQuery('li.genre').removeClass('active');
			jQuery(this).addClass('active');
			
			
            var genreid = jQuery(this).attr('data-genre');
            jQuery.ajax({
                
                url: frontend_ajax_object.ajaxurl,
				type:'post',
                data: {
                    action: 'movie_filter',
                    cat_id: genreid // <-- category ID of clicked item / link
                },
				success : function( response ) {
					jQuery('.movie-list').html(response);
					//console.log(response);
				}
            })
            
        });
    });
})(jQuery);


jQuery(document).ready(function () {
   jQuery(document).ajaxStart(function () {
		jQuery('.movie-list').empty();
       jQuery("#loading").show();
    }).ajaxStop(function () {
        jQuery("#loading").hide();
    });
})


	

        //var page_numbers = jQuery(".page-numbers");
        
		//page_numbers.on( 'click', function(event){
			
		jQuery(document).on('click','.page-numbers',function(event){
				
			event.preventDefault();
			var pageurl = jQuery(this).attr('href');
			var pagenum = pageurl.slice(-3);
			var pagenumclean = pagenum.replace(/\D/g, '');
			
			var catname = jQuery('li.genre.active').attr('data-genre');
			
			if(pagenumclean == ''){
				
				pagenumclean == 1;
				
			}
			
			console.log(pagenumclean);
				
            jQuery.ajax({
                
                url: frontend_ajax_object.ajaxurl,
				type:'post',
                data: {
                    action: 'pagination_filter',
                    pagenumber: pagenumclean, // <-- category ID of clicked item / link
					genrename:catname,
                },
				success : function( response ) {
					jQuery('.movie-list').html(response);
					//console.log(response);
				}
            }) 
            
        });

</script>
/************ end  file : front-end.js *****************************/


/************ start file : functions.php   *****************************/


<?php


function register_post_type_movies(){
	
$labels = array(
		'name'                  => _x( 'Movies', 'movies', 'twentytwentytwo' ),
        'singular_name'         => _x( 'Movie', 'Post type singular name', 'twentytwentytwo' ),
        'menu_name'             => _x( 'Movies', 'Movies', 'twentytwentytwo' ),
        'name_admin_bar'        => _x( 'Movie', 'Add New on Toolbar', 'twentytwentytwo' ),
        'add_new'               => __( 'Add Movie', 'twentytwentytwo' ),
        'add_new_item'          => __( 'Add New Movie', 'twentytwentytwo' ),
     
			);
		
		$args = array(
		'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
		'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
		);
		
		
		register_post_type('movies',$args);
}	

add_action('init','register_post_type_movies');






function wpdocs_register_private_taxonomy() {
    $args = array(
        'label'        => __( 'Genre', 'twentytwentytwo' ),
        'public'       => true,
        'rewrite'      => false,
        'hierarchical' => true
    );
     
    register_taxonomy( 'genre', 'movies', $args );
}
add_action( 'init', 'wpdocs_register_private_taxonomy', 0 );




/*********************/


add_action('wp_ajax_movie_filter', 'movies_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_movie_filter', 'movies_filter_function');

function movies_filter_function(){
	
	
 $genreid = $_POST['cat_id'];
 
 //$pagenum = $_POST['pagenumber'];
 
 
?>
<div class="container">
<ul>
<?php 


$args = array(  
        'post_type' => 'movies',
        'post_status' => 'publish',
        'posts_per_page' => 1,
		//'paged' => $pagenum,
		'tax_query' => array(
        array (
            'taxonomy' => 'genre',
            'field' => 'slug',
            'terms' => $genreid,
        )
    ),
    
    );

  $loop = new WP_Query( $args );
  
  if( $loop->have_posts() ):
  
  while ( $loop->have_posts() ) : $loop->the_post(); 
  
	
	$genre = get_the_terms(get_the_ID(),'genre');
	

?>

<li>
	<h3><?php the_title();?></h3>
		<?php foreach($genre as $gen ){ ?>
		<span><?php echo $gen->name; ?></span>
		
		<?php } ?>
		
	<p><?php the_content();?></p>
</li>

<?php endwhile; else: 

echo "No movies found";

endif;

?>

</ul>

<div class = "news-list-pagination" >
 
<?php


$total_pages = $loop -> max_num_pages;
 
if ($total_pages > 1) {
 
    $current_page = max(1, get_query_var('paged'));
	
	//	echo get_pagenum_link(1);
 
    echo paginate_links(array(
        'base' => "http://localhost/wptest2/movies-page/".
        '%_%',
        //'format' => '/page/%#%',
        'current' => $pagenum,
        'total' => $total_pages,
        'prev_text' => __('<< Pre'),
        'next_text' => __('Next >>'),
	
    ));
} ?>
 
<?php wp_reset_postdata(); ?>
 
</div>
</div>
<?php
wp_reset_postdata();
die();
}



/*****************************************/




add_action('wp_ajax_pagination_filter', 'paginate_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_pagination_filter', 'paginate_filter_function');

function paginate_filter_function(){
	
	
 $pagenum = $_POST['pagenumber'];
 $genrename = $_POST['genrename'];
 
 
?>
<div class="container">
<ul>
<?php 



$args = array(  
        'post_type' => 'movies',
        'post_status' => 'publish',
        'posts_per_page' => 1,
		'paged' => $pagenum,
		'tax_query' => array(
        array (
            'taxonomy' => 'genre',
            'field' => 'slug',
            'terms' => $genrename,
        ))
		
		
    );
   

  $loop = new WP_Query( $args );
  
  if( $loop->have_posts() ):
  
  while ( $loop->have_posts() ) : $loop->the_post(); 
  
	
	$genre = get_the_terms(get_the_ID(),'genre');
	

?>

<li>
	<h3><?php the_title();?></h3>
		<?php foreach($genre as $gen ){ ?>
		<span><?php echo $gen->name; ?></span>
		
		<?php } ?>
		
	<p><?php the_content();?></p>
</li>

<?php endwhile; else: 

echo "No movies found";

endif;

?>

</ul>

<div class = "news-list-pagination" >
 
<?php


$total_pages = $loop -> max_num_pages;
 
if ($total_pages > 1) {
 
    $current_page = max(1, get_query_var('paged'));
	
	//	echo get_pagenum_link(1);
 
    echo paginate_links(array(
        'base' => "http://localhost/wptest2/movies-page/".
        '%_%',
        //'format' => '/page/%#%',
        'current' => $pagenum,
        'total' => $total_pages,
        'prev_text' => __('<< Pre'),
        'next_text' => __('Next >>'),
	
    ));
} ?>
 
<?php wp_reset_postdata(); ?>
 
</div>
</div>
<?php

die();
}
