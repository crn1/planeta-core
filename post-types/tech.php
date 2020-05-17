<?php

function planeta_register_post_type_tech()
{
	$labels_techs = array(
		'name'									=> esc_html__('Tech Stack', 'planeta'),
		'singular_name'					=> esc_html__('Tech Stack', 'planeta'),
		'add_new'								=> esc_html__('Add New Item', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit Item', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No items found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No items found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Item updated.', 'planeta'),
	);
	$args_techs = array(
		'labels'								=> $labels_techs,
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
	register_post_type('tech', $args_techs);
}
add_action('init', 'planeta_register_post_type_tech');

//Add to Submenu
function planeta_add_tech_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Tech Stack', 'planeta'),
	esc_html__('Tech Stack', 'planeta'),
	'manage_options',
	'edit.php?post_type=tech');
}
add_action('admin_menu', 'planeta_add_tech_submenu');

add_filter('manage_tech_posts_columns', 'planeta_tech_columns');
function planeta_tech_columns($columns)
{
	$columns['featured_image'] = esc_html__('Logo', 'planeta');
	unset($columns['date']);
	return $columns;
}

add_action('manage_tech_posts_custom_column', 'custom_tech_column', 10, 2);
function custom_tech_column($column, $post_id)
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

add_filter('manage_edit-tech_sortable_columns', 'planeta_tech_columns_sortable');
function planeta_tech_columns_sortable($columns)
{
	$columns['title'] = 'title';
	return $columns;
}

?>
