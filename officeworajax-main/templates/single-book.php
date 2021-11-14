<?php
/**
 * Register post type :: Book
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

the_post();
the_title();?>


<?php 

get_footer();