<?php
/**
 *Plugin Name: Planeta Core
 *Description: Core functionality for Planeta Theme
 *Version: 1.0.0
 *Author: Đorđe G.
 *Author URI: https://github.com/crn1
 *Text Domain: planeta-core
**/

if(!defined('ABSPATH')): exit(); endif;

//Define plugin constants
define('PLANETA_CORE_PATH', trailingslashit(plugin_dir_path(__FILE__)));

//Planeta Welcome Menu
require_once PLANETA_CORE_PATH . '/welcome.php';

function planeta_register_welcome_page() {
	add_menu_page(
		'Planeta',
		'Planeta',
		'manage_options',
		'planeta_welcome',
		'planeta_get_welcome_page',
		'dashicons-admin-site-alt', 2);

	add_submenu_page(
		'planeta_welcome',
		'Welcome',
		'Welcome',
		'manage_options',
		'planeta_welcome',
		'planeta_get_welcome_page', 0);
}
add_action('admin_menu', 'planeta_register_welcome_page');

//Register Custom Post Types
require_once PLANETA_CORE_PATH . '/inc/post-types/testimonial.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/project.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/client.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/tech.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/service.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/team.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/number.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/price.php';
require_once PLANETA_CORE_PATH . '/inc/post-types/generic.php';

//Register Contact Form
require_once PLANETA_CORE_PATH . '/inc/contact-form.php';

//Internationalization
add_action('init', 'planeta_core_i18n_setup');
function planeta_core_i18n_setup()
{
	load_plugin_textdomain('planeta', false, PLANETA_CORE_PATH . '/languages/');
}

//Admin Styles
function planeta_init_admin_styles()
{
	wp_enqueue_style('planeta-admin-styles', plugins_url('/css/admin.css', __FILE__));
	wp_enqueue_script('planeta-admin-script', plugins_url('/js/admin.js', __FILE__), array('jquery'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'planeta_init_admin_styles');

//One Click Demo Import Setup
function planeta_ocdi_import_files()
{
	return array(
		array(
			'import_file_name'							=> esc_html__('Agency', 'planeta'),
			'local_import_file'            	=> PLANETA_CORE_PATH . '/ocdi/agency-1-demo-content.xml',
			'local_import_widget_file'     	=> PLANETA_CORE_PATH . '/ocdi/agency-1-widgets.json',
			'local_import_customizer_file' 	=> PLANETA_CORE_PATH . '/ocdi/agency-1-customizer.dat',
		),
		array(
			'import_file_name'							=> esc_html__('Agency Portfolio', 'planeta'),
			'local_import_file'            	=> PLANETA_CORE_PATH . '/ocdi/agency-portfolio-1-demo-content.xml',
			'local_import_widget_file'     	=> PLANETA_CORE_PATH . '/ocdi/agency-portfolio-1-widgets.wie',
			'local_import_customizer_file' 	=> PLANETA_CORE_PATH . '/ocdi/agency-portfolio-1-customizer.dat',
		),
	);
}
add_filter('pt-ocdi/import_files', 'planeta_ocdi_import_files');
add_filter('pt-ocdi/disable_pt_branding', '__return_true');

?>
