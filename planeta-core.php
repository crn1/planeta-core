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

?>
