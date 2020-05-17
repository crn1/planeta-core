<?php

function planeta_metabox_number_display()
{
	global $post;
	$number_value = get_post_meta($post->ID, 'number_value', true);
	$number_of_what = get_post_meta($post->ID, 'number_of_what', true);
	$number_description = get_post_meta($post->ID, 'number_description', true);
	$number_url = get_post_meta($post->ID, 'number_url', true);

	$number = esc_html__('Number & Unit', 'planeta');
	$of_what = esc_html__('Of What?', 'planeta');
	$description = esc_html__('Description', 'planeta');
	$url = esc_html__('Button URL', 'planeta');
?>
	<fieldset>
		<legend class='screen-reader-text'>Number Information</legend>
		<table class='form-table'>
			<tr>
				<td class='first'>
					<?php echo $number; ?>
				</td>
				<td>
					<input
						required
						size='30'
						type='text'
						name='number_value'
						class='widefat'
						value='<?php echo esc_attr($number_value); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $of_what; ?>
				</td>
				<td>
					<input
						required
						size='30'
						type='text'
						name='number_of_what'
						class='widefat'
						value='<?php echo esc_attr($number_of_what); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $description; ?>
				</td>
				<td>
					<?php wp_editor(
						$number_description,
						'number_description', array(
							'media_buttons'	=> false,
							'quicktags'			=> false,
							'teeny'					=> true,
						)); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $url; ?>
				</td>
				<td>
					<input
						size='30'
						type='url'
						name='number_url'
						class='widefat'
						value='<?php echo esc_url($number_url); ?>'
					/>
				</td>
			</tr>
		</table>
	</fieldset>
<?php }

function planeta_add_metabox_number()
{
	add_meta_box(
		'planeta_metabox_number',
		'Number Information',
		'planeta_metabox_number_display',
		'number',
		'advanced',
		'high'
	);
}

function planeta_metabox_number_save($post_id)
{
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);

	if($is_autosave || $is_revision)
	{
		return;
	}

	$post = get_post($post_id);
	if($post->post_type == 'number')
	{
		if(array_key_exists('number_value', $_POST))
		{
			update_post_meta($post_id, 'number_value', $_POST['number_value']);
		}
		if(array_key_exists('number_of_what', $_POST))
		{
			update_post_meta($post_id, 'number_of_what', $_POST['number_of_what']);
		}
		if(array_key_exists('number_description', $_POST))
		{
			update_post_meta($post_id, 'number_description', $_POST['number_description']);
		}
		if(array_key_exists('number_url', $_POST))
		{
			update_post_meta($post_id, 'number_url', $_POST['number_url']);
		}
	}
}
add_action('save_post', 'planeta_metabox_number_save');

function planeta_register_post_type_number()
{
	$labels_numbers = array(
		'name'									=> esc_html__('Numbers', 'planeta'),
		'singular_name'					=> esc_html__('Number', 'planeta'),
		'add_new'								=> esc_html__('Add New Number', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit Number', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No numbers found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No numbers found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Number updated.', 'planeta'),
	);
	$args_numbers = array(
		'labels'								=> $labels_numbers,
		'public'								=> true,
		'exclude_from_search'		=> true,
		'publicly_queryable'		=> false,
		'show_in_nav_menus'			=> false,
		'show_in_menu'					=> false,
		'show_in_rest'					=> false,
		'register_meta_box_cb'	=> 'planeta_add_metabox_number',
		'supports'							=> false,
	);
	register_post_type('number', $args_numbers);
}
add_action('init', 'planeta_register_post_type_number');

//Add to Submenu
function planeta_add_number_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Numbers', 'planeta'),
	esc_html__('Numbers', 'planeta'),
	'manage_options',
	'edit.php?post_type=number');
}
add_action('admin_menu', 'planeta_add_number_submenu');

add_filter('manage_number_posts_columns', 'planeta_number_columns');
function planeta_number_columns($columns)
{
	$columns['number_value'] = esc_html__('Number', 'planeta');
	$columns['number_of_what'] = esc_html__('Of What?', 'planeta');
	$columns['number_description'] = esc_html__('Description', 'planeta');
	unset($columns['title']);
	unset($columns['date']);
	return $columns;
}

add_action('manage_number_posts_custom_column', 'custom_number_column', 10, 2);
function custom_number_column($column, $post_id)
{
	global $post;
	switch($column)
	{
		case 'number_value':
			$number_value = get_post_meta($post->ID, 'number_value', true);
			echo esc_html($number_value);
			break;

		case 'number_of_what':
			$number_of_what = get_post_meta($post->ID, 'number_of_what', true);
			echo esc_html($number_of_what);
			break;

		case 'number_description':
			$number_description = get_post_meta($post->ID, 'number_description', true);
			echo esc_html($number_description);
			break;
	}
}

add_filter('manage_edit-number_sortable_columns', 'planeta_number_columns_sortable');
function planeta_number_columns_sortable($columns)
{
	$columns['number_value'] = 'number_value';
	$columns['number_of_what'] = 'number_of_what';
	$columns['number_description'] = 'number_description';
	return $columns;
}

?>
