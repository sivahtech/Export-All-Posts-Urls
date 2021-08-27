<?php
/*
Plugin Name: Export All Posts Urls
Description: This plugin allow you to export post urls and export page urls and count pages and posts and allow you to copy page urls ,allow you to export pages as pdf, allow you to export as csv, allow you to export as excel also allow you to print.
Version: 1.0
Author: Sivahtech
Author URI: https://www.sivahtech.com/
*/
  
add_action('admin_menu', 'sh_epua_post_check_admin_menu');
 
function sh_epua_post_check_admin_menu(){
    add_menu_page( 'Export Posts', 'Export Posts/Pages', 'manage_options', 'export-post-setting-page', 'sh_epua_export_post_setting' );
}
function sh_epua_export_post_setting(){

    include(plugin_dir_path(__FILE__) . 'sh-export-post-settings.php');

}
if ( ! function_exists( 'sh_epua_exportall_posts_urls_on_activate' ) ) {
	function sh_epua_exportall_posts_urls_on_activate() {
		if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_version = $plugin_data['Version'];
			$plugin_name = $plugin_data['Name'];
			wp_die( '<h1>' . __('Could not activate plugin: PHP version error') . '</h1><h2>PLUGIN: <i>' . $plugin_name . ' ' . $plugin_version . '</i></h2><p><strong>' . __('You are using PHP version') . ' ' . PHP_VERSION . '</strong>. ' . __( 'This plugin has been tested with PHP versions 5.4 and greater.') . '</p><p>' . __('WordPress itself recommends using PHP version 7.3 or greater') . ': <a href="https://wordpress.org/about/requirements/" target="_blank">' . __('Official WordPress requirements') . '</a>' . '. ' . __('Please upgrade your PHP version or contact your Server administrator.') . '</p>', __('Could not activate plugin: PHP version error'), array( 'back_link' => true ) );

		}
		set_transient( 'sh_exportall_posts_urls_is_activate', true, 30 );
	}

	register_activation_hook( __FILE__, 'sh_epua_exportall_posts_urls_on_activate' );
}
if ( ! function_exists( 'sh_epua_redirect_on_exportall_posts_urls_activation' ) ) {
	function sh_epua_redirect_on_exportall_posts_urls_activation() {

		if ( ! get_transient( 'sh_exportall_posts_urls_is_activate' ) ) {
			return;
		}

		delete_transient( 'sh_exportall_posts_urls_is_activate' );
		$url=site_url()."/wp-admin/admin.php?page=export-post-setting-page";
		wp_safe_redirect($url);

	}
	add_action( 'admin_init', 'sh_epua_redirect_on_exportall_posts_urls_activation' );
}
if ( ! function_exists( 'sh_epua_add_export_all_scripts' ) ) {
	function sh_epua_add_export_all_scripts() {
		wp_register_style('setting', plugins_url('assets/css/setting.css',__FILE__ ));
		wp_register_style('datatable', plugins_url('assets/css/style.css',__FILE__ ));
		wp_register_style('buttonscss',   plugins_url('assets/css/button.css',__FILE__ ));
		wp_register_script( 'datatable',plugins_url('assets/js/datatble.js',__FILE__ ));
		wp_register_script( 'buttons', plugins_url('assets/js/buttons.js',__FILE__ ));
		wp_register_script( 'zipjs', plugins_url('assets/js/zipjs.js',__FILE__ ));
		wp_register_script( 'pdfjs', plugins_url('assets/js/pdf.js',__FILE__ ));
		wp_register_script( 'fontjs', plugins_url('assets/js/fonts.js',__FILE__ ));
		wp_register_script( 'html5js', plugins_url('assets/js/html.js',__FILE__ ));
		wp_register_script( 'printjs', plugins_url('assets/js/print.js',__FILE__ ));
		wp_register_script( 'custom', plugins_url('assets/js/custom.js',__FILE__ ));
		wp_enqueue_style('setting');
		wp_enqueue_style('datatable');
		wp_enqueue_style('buttonscss');
		wp_enqueue_script('datatable');
		wp_enqueue_script('buttons');
		wp_enqueue_script('zipjs');
		wp_enqueue_script('pdfjs');
		wp_enqueue_script('fontjs');
		wp_enqueue_script('html5js');
		wp_enqueue_script('printjs');
		wp_enqueue_script('custom');
	}

	add_action( 'admin_init','sh_epua_add_export_all_scripts');
}
if ( ! function_exists( 'sh_epua_admin_footer_text' ) ) {
	add_filter( 'admin_footer_text', 'sh_epua_admin_footer_text' );

	function sh_epua_admin_footer_text( $footer_text ) {

		$current_screen = get_current_screen();

		$is_export_all_urls_screen = ( $current_screen && false !== strpos( $current_screen->id, 'export-post-setting-page' ) );

		if ( $is_export_all_urls_screen ) {
			$footer_text = 'Enjoyed <strong>Export All  POSTS/PAGES URLs</strong>? Please leave us a email at info@sivahtech.com. We really appreciate your support! ';
		}

		return $footer_text;
	}
}
?>