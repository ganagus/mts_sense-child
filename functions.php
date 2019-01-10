<?php
/**
 * Add main style.
 */
add_action( 'wp_enqueue_scripts', 'mts_sense_enqueue_styles' );
function mts_sense_enqueue_styles() {
 
    $parent_style = 'parent-style';
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    // wp_enqueue_style( 'child-style',
    //     get_stylesheet_directory_uri() . '/style.css',
    //     array( $parent_style ),
    //     wp_get_theme()->get('Version')
    // );
}

/**
 * Remove parent theme's metabox configuration.
 */
add_action( 'init', 'mts_remove_metabox_action' );
function mts_remove_metabox_action(){
	remove_action('add_meta_boxes', 'mts_add_sidebar_metabox');
}

/**
 * Add a "Sidebar" selection metabox to post, page, and course.
 */
add_action('add_meta_boxes', 'mts_child_add_sidebar_metabox', 12);
function mts_child_add_sidebar_metabox() {
	$screens = array('post', 'page', 'course');
	foreach ($screens as $screen) {
		add_meta_box(
			'mts_sidebar_metabox',          // id
			__('Sidebar', 'ad-sense' ),	    // title
			'mts_inner_sidebar_metabox',    // callback
			$screen,                        // post_type
			'side',	                        // context (normal, advanced, side)
			'low'                           // priority (high, core, default, low)
		);
	}
}