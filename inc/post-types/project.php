<?php

function planeta_project_enable_gutenberg($can_edit, $post)
{
	if(empty($post->ID)) { return $can_edit; }
	if($post_type === 'project') { return true; }
	return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'planeta_project_enable_gutenberg', 10, 2);

function planeta_register_post_type_project()
{
	$labels_projects = array(
		'name'									=> esc_html__('Projects', 'planeta'),
		'singular_name'					=> esc_html__('Project', 'planeta'),
		'add_new'								=> esc_html__('Add New Project', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit Project', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No projects found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No projects found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Project updated.', 'planeta'),
	);
	$args_projects = array(
		'labels'								=> $labels_projects,
		'public'								=> true,
		'exclude_from_search'		=> true,
		'publicly_queryable'		=> true,
		'show_in_nav_menus'			=> false,
		'show_in_menu'					=> false,
		'show_in_rest'					=> true,
		'supports'							=> array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
		),
		'taxonomies' 						=> array('category', 'post_tag', 'page-category'),
	);
	register_post_type('project', $args_projects);
}
add_action('init', 'planeta_register_post_type_project');

//Add to Submenu
function planeta_add_project_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Projects', 'planeta'),
	esc_html__('Projects', 'planeta'),
	'manage_options',
	'edit.php?post_type=project');
}
add_action('admin_menu', 'planeta_add_project_submenu');

?>
