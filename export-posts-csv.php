/****** Add export button Boutiques **********/


function admin_boutiques_export_button( $which ) {
    global $typenow;
  
    if ( 'boutiques' === $typenow && 'top' === $which ) {
        ?>
        <input type="submit" name="export_boutique_details" class="button button-primary" value="<?php _e('Export Boutiques'); ?>" />
        <?php
    }
}
 
add_action( 'manage_posts_extra_tablenav', 'admin_boutiques_export_button', 20, 1 );


/*********** export boutiques ********/

function func_export_boutiques_details() {
	
    if(isset($_GET['export_boutique_details'])) {
        $arg = array(
            'post_type' => 'boutiques',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
  
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) {
  
            header('Content-type: text/csv;charset=utf-8');
            header('Content-Disposition: attachment; filename="boutiques-details.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
  
            $file = fopen('php://output', 'w');
			
			// to solve UTF encode in Excel view 
          
			fputs( $file, $bom = chr(0xEF) . chr(0xBB) . chr(0xBF) );

  
            fputcsv($file, array('Boutique Name','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','Boutique Link'));
  
            foreach ($arr_post as $post) {
                setup_postdata($post);
                               
				
                fputcsv($file, array(get_the_title(),get_field('_storeopening_monday'),get_field('_storeopening_tuesday'),get_field('_storeopening_wednesday'),get_field('_storeopening_thursday'),get_field('_storeopening_friday'),get_field('_storeopening_saturday'),get_field('_storeopening_sunday'),get_the_permalink()));
            }
  
            exit();
        }
    }
}
 
add_action( 'init', 'func_export_boutiques_details' );
