<?php

function planeta_register_post_type_client()
{
	$labels_clients = array(
		'name'									=> esc_html__('Clients', 'planeta'),
		'singular_name'					=> esc_html__('Client', 'planeta'),
		'add_new'								=> esc_html__('Add New Client', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit Client', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No clients found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No clients found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Client updated.', 'planeta'),
	);
	$args_clients = array(
		'labels'								=> $labels_clients,
		'public'								=> true,
		'exclude_from_search'		=> true,
		'publicly_queryable'		=> false,
		'show_in_nav_menus'			=> false,
		'show_in_menu'					=> false,
		'show_in_rest'					=> false,
		'supports'							=> array(
			'title',
			'thumbnail',
		),
	);
	register_post_type('client', $args_clients);
}
add_action('init', 'planeta_register_post_type_client');

//Add to Submenu
function planeta_add_client_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Clients', 'planeta'),
	esc_html__('Clients', 'planeta'),
	'manage_options',
	'edit.php?post_type=client');
}
add_action('admin_menu', 'planeta_add_client_submenu');

add_filter('manage_client_posts_columns', 'planeta_client_columns');
function planeta_client_columns($columns)
{
	$columns['featured_image'] = esc_html__('Logo', 'planeta');
	unset($columns['date']);
	return $columns;
}

add_action('manage_client_posts_custom_column', 'custom_client_column', 10, 2);
function custom_client_column($column, $post_id)
{
	global $post;
	switch($column)
	{
		case 'title':
			$title = get_the_title();
			echo $title;
			break;
		case 'featured_image':
			$featured_image = get_the_post_thumbnail_url();
			echo "<img style='max-height: 512px; max-width: 512px;' src='${featured_image}' />";
			break;
	}
}

add_filter('manage_edit-client_sortable_columns', 'planeta_client_columns_sortable');
function planeta_client_columns_sortable($columns)
{
	$columns['title'] = 'title';
	return $columns;
}

?>
