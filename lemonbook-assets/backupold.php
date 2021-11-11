<?php
/**
 * Plugin Name: Lemon Book
 * Description: This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Plugin URI: http://webdevalamin.com/bti-test/
 * Author: Mohammad Al Amin
 * Author URI: http://webdevalamin.com/bti-test/
 * Text Domain: lemonbook
 * Version: 1.0.0
 */
 
 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// Registering LemonBook Files

function lemonbook_files(){
	
	
	wp_enqueue_style( 'lemonbook', plugin_dir_url( __FILE__ ) . 'assets/css/lemonbook.css', null, '1.0.0' );
	
	
	wp_enqueue_script('lemonbook-js',  plugin_dir_url( __FILE__ ) . '/assets/js/lemonbook.js', array('jquery'), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'lemonbook_files' );



// Add action to init to register custom post type
add_action( 'init', 'lemonbook_register_custom_post_type_book' );

// Create custom post type Book
function lemonbook_register_custom_post_type_book() {
    register_post_type( 'lemonbook',
        array(
        'labels'       => array(
            'name'               => esc_html( 'Books', 'lemonbook' ),
            'singular_name'      => esc_html( 'Book', 'lemonbook' ),
            'add_new'            => esc_html( 'Add New Book', 'lemonbook' ),
            'add_new_item'       => esc_html( 'Add New Book', 'lemonbook' ),
            'edit'               => esc_html( 'Edit Book', 'lemonbook' ),
            'edit_item'          => esc_html( 'Edit Book', 'lemonbook' ),
            'new_item'           => esc_html( 'New Book', 'lemonbook' ),
            'view'               => esc_html( 'View Book', 'lemonbook' ),
            'view_item'          => esc_html( 'View Book', 'lemonbook' ),
            'search_items'       => esc_html( 'Search Book', 'lemonbook' ),
            'not_found'          => esc_html( 'No Book found', 'lemonbook' ),
            'not_found_in_trash' => esc_html( 'No Book found in Trash', 'lemonbook' ),
        ),
        'public'              => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'has_archive'         => true,
		'menu_icon'          => 'dashicons-book',
        'supports'     => array(
            'title',
            'editor',
            'thumbnail'
        )
    ) );
    
    register_taxonomy('book-category', ['lemonbook'], [
		'label' => __('Book Category', 'lemonbook'),
		'hierarchical' => true,
		'rewrite' => ['slug' => 'book-category'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Book Category', 'lemonbook'),
			'all_items' => __('All Book Categories', 'lemonbook'),
			'edit_item' => __('Edit Book Category', 'lemonbook'),
			'view_item' => __('View Book Category', 'lemonbook'),
			'update_item' => __('Update Book Category', 'lemonbook'),
			'add_new_item' => __('Add New Book Category', 'lemonbook'),
			'new_item_name' => __('New Book Category Name', 'lemonbook'),
			'search_items' => __('Search Book Category', 'lemonbook'),
			'parent_item' => __('Parent Book Category', 'lemonbook'),
			'parent_item_colon' => __('Parent Book Category:', 'lemonbook'),
			'not_found' => __('No Book Category found', 'lemonbook'),
		]
	]);
}

add_shortcode('books', 'lemonbook_shortcode_handler_function');

function lemonbook_shortcode_handler_function($atts, $content = null) {
    
global $wp_query;
  
  wp_enqueue_script('isotope-lemonbook',  plugin_dir_url( __FILE__ ) . '/assets/js/isotope.pkgd.min.js', array('jquery'), '3.0.6', true);
  //wp_enqueue_script('isotope-load',  plugin_dir_url( __FILE__ ) . '/assets/js/isotope.load.js', array('jquery', 'isotope-lemonbook'), '1.0.0', true);
  
  
  extract( shortcode_atts( array(
        'per_page' => '8'
    ), $atts) );
    
  $lemonbook_category = get_terms('book-category');
  $dynamic_number = rand(378463728, 13784631786);
  
  $lemonbook_markup = '		
		<script>
			jQuery(document).ready(function($){
				
				$(".lemonbook-shorting li").click(function(){
    					$(".lemonbook-shorting li").removeClass("active");
    					$(this).addClass("active");
    					
    					var selector = $(this).attr("data-filter");
    					$(".lemonbook-list-'.esc_attr($dynamic_number).'").isotope({
    						filter: selector,
    					});
    				});

			    });
			    
			    jQuery(window).load(function(){
					jQuery(".lemonbook-list-'.esc_attr($dynamic_number).'").isotope();
				});
				
		</script>';
		
		$lemonbook_markup .= '<div class="book-wrapper">';
		
		$lemonbook_markup .= '
			<ul class="lemonbook-shorting">
				<li class="active" data-filter="*">'.esc_html("All").'</li>';
				
				if(!empty( $lemonbook_category ) && ! is_wp_error( $lemonbook_category )){
					foreach( $lemonbook_category as $category ){
						$lemonbook_markup .= '<li data-filter=".'.esc_attr($category->slug).'">'.esc_html($category->name).'</li>';
					}						
				}
				
		$lemonbook_markup .= '</ul>';

		$lemonbook_markup .= '
				<div class="book-list lemonbook-list-'.esc_html($dynamic_number).'">';
				
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$lemonbook_array = new WP_Query( array('posts_per_page' => $per_page, 'post_type' => 'lemonbook', 'paged' => $paged) );
				while($lemonbook_array->have_posts()) : $lemonbook_array->the_post();
				
				$lemonbook_category = get_the_terms( get_the_ID(), 'book-category');
				
				if( $lemonbook_category && ! is_wp_error( $lemonbook_category )){					
					$lemonbook_category_list = array();
					foreach( $lemonbook_category as $single_book_category ){
						$lemonbook_category_list[] = $single_book_category->slug;
					}
					$lemonbook_assigned_category = join(' ', $lemonbook_category_list);
				}else{
					$lemonbook_assigned_category = '';
				}
				
	$lemonbook_markup .= '
					<div class="single-book-list '.$lemonbook_assigned_category.'">
						<div class="single-book-box">
							<div class="book-box-bg" style="background-image: url('.esc_url(get_the_post_thumbnail_url( get_the_ID(), 'full' )).')"></div>
							
							<div class="book-box-content"><div class="book-box-content-inner"><h3>'.esc_html(get_the_title()).'</h3>
							<p>'.esc_html(wp_trim_words( get_the_content(), 15, "" )).'</p>
							<a class="readmore-btn" href="'.esc_url(get_permalink()).'">'.esc_html("Read More").'</a></div>
						</div></div>
					</div>';
				endwhile;
				wp_reset_query();
				
	$lemonbook_markup .= '</div>';
	
	if (  $lemonbook_array->max_num_pages > 1 ){
	    
	    $lemonbook_markup .= '<div class="loadmore-btn-wrapp"><div class="loadMore" id="loadMore">'.esc_html("Load More").'</div></div>';
	}
	
	$lemonbook_markup .= '</div>';
	
	return $lemonbook_markup;
}


function lemonbook_load_more_scripts() {
 
	global $wp_query; 

	wp_enqueue_script( 'lemonbook_loadmore', plugin_dir_url( __FILE__ ) . 'assets/js/loadmore.js', array('jquery'), '1.0.0', true );
 
	wp_localize_script( 'lemonbook_loadmore', 'lemonbook_loadmore_params', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ), 
		'posts' => json_encode( $wp_query->query_vars ), 
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
}
 
add_action( 'wp_enqueue_scripts', 'lemonbook_load_more_scripts' );

function lemonbook_loadmore_ajax_handler($atts, $content = null){

	global $wp_query;

	$lemonbook_category = get_terms('book-category');
 
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	//$args['post_type'] = 'lemonbook';
	
	//$lemonbook_posts = new WP_Query( array('post_type' => 'lemonbook') );
 
	// it is always better to use WP_Query but not here
	query_posts( $args );

	?>
	<?php

 
	if( have_posts() ) :
 
		while( have_posts() ): the_post();

		$lemonbook_category = get_the_terms( get_the_ID(), 'book-category');
				
		if( $lemonbook_category && ! is_wp_error( $lemonbook_category )){					
			$lemonbook_category_list = array();
			foreach( $lemonbook_category as $single_book_category ){
				$lemonbook_category_list[] = $single_book_category->slug;
			}
			$lemonbook_assigned_category = join(' ', $lemonbook_category_list);
		}else{
			$lemonbook_assigned_category = '';
		}
 
		?>

					<div class="single-book-list <?php echo $lemonbook_assigned_category; ?>">
						<div class="single-book-box">
							<div class="book-box-bg" style="background-image: url(<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'full' ));?>)"></div>
							
							<div class="book-box-content"><div class="book-box-content-inner">
								<h3><?php echo esc_html(get_the_title()); ?></h3>
								<p><?php echo esc_html(wp_trim_words( get_the_content(), 15, "" )); ?></p>
								<a class="readmore-btn" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html("Read More"); ?></a>
							</div>
						</div>
					</div>

 
		<?php
		endwhile;
 
	endif;
	die();
}
 
 
add_action('wp_ajax_loadmore', 'lemonbook_loadmore_ajax_handler'); 
add_action('wp_ajax_nopriv_loadmore', 'lemonbook_loadmore_ajax_handler');



function lemonbook_single_template($file) {
    global $post;
    if( 'lemonbook' == $post->post_type ){
        $file_path = plugin_dir_path( ( __FILE__ ) ) . '/templates/single-book.php'; 
    }
    $file = $file_path;
    return $file;
}

add_filter( 'single_template', 'lemonbook_single_template' );