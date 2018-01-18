<?php if ( !defined('ABSPATH')){ exit; } // Exit if accessed directly

/*
Plugin Name: A11yEditor for WordPress
Plugin URI: http://wordpress.ckeditor.com/
Description: Replaces the default WordPress editor with <a href="http://ckeditor.com/"> CKEditor</a>
Version: 0.5
Author: JaEun Jemma Ku
Author URI: https://www.library.illinois.edu/bios/jku/
*/

add_action('init', 'ckeditor_init');

function ckeditor_init(){
	global $ckeditor_wordpress;
	require_once dirname(__FILE__) . '/ckeditor_class.php';

	if (is_admin()){
		add_action('admin_menu', array(&$ckeditor_wordpress, 'add_option_page'));
		add_action('admin_head', array(&$ckeditor_wordpress, 'add_admin_head'));
		add_action('personal_options_update', array(&$ckeditor_wordpress, 'user_personalopts_update'));
		add_action('admin_print_scripts', array(&$ckeditor_wordpress, 'add_post_js'));
		add_action('admin_print_footer_scripts', array(&$ckeditor_wordpress, 'remove_tinymce'));
		add_action('admin_init', array(&$ckeditor_wordpress, 'deregister_editor_expand' ));
		// TODO: fix support for V4
		// add_filter('ckeditor_external_plugins', array(&$ckeditor_wordpress, 'ckeditor_linkbrowser_plugin'));
		// add_action('wp_ajax_linkbrowser_loader', array(&$ckeditor_wordpress, 'ckeditor_linkbrowser_loader'));
		// add_action('wp_ajax_linkbrowser_search', array(&$ckeditor_wordpress, 'ckeditor_linkbrowser_search'));
	}

	add_action( 'wp_print_scripts', array(&$ckeditor_wordpress, 'add_comment_js'));
	//add_filter( 'ckeditor_external_plugins', array(&$ckeditor_wordpress, 'ckeditor_wpmore_plugin') );
	add_filter( 'ckeditor_buttons', array(&$ckeditor_wordpress, 'ckeditor_wpmore_button') );
	//add_filter( 'ckeditor_external_plugins', array(&$ckeditor_wordpress, 'ckeditor_wpgallery_plugin') );
	add_filter( 'ckeditor_load_lang_options', array(&$ckeditor_wordpress, 'ckeditor_load_lang_options') );

	//add filter to change content before insert/update to database - needed for wpeditimage plugin
	add_filter( 'wp_insert_post_data' , array(&$ckeditor_wordpress, 'ckeditor_insert_post_data_filter'));

	
}
