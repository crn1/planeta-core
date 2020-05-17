<?php

function planeta_metabox_price_display()
{
	global $post;
	$price_tag = get_post_meta($post->ID, 'price_tag', true);
	$price_before = get_post_meta($post->ID, 'price_before', true);
	$price_after = get_post_meta($post->ID, 'price_after', true);
	$price_highlight = get_post_meta($post->ID, 'price_highlight', true);
	$price_description = get_post_meta($post->ID, 'price_description', true);

	$tag = esc_html__('Value and Currency', 'planeta');
	$description = esc_html__('Description', 'planeta');
	$before = esc_html__('Text Before Value', 'planeta');
	$after = esc_html__('Text After Value', 'planeta');
	$highlight = esc_html__('Highlight Price', 'planeta');
	$this_option = esc_html__('This option sets price value to appear slightly bigger and applies primary color to it, if enabled in Customizer.', 'planeta');
?>
	<fieldset>
		<legend class='screen-reader-text'>Price Information</legend>
		<table class='form-table'>
			<tr>
				<td class='first'>
					<?php echo $tag; ?>
				</td>
				<td>
					<input
						required
						size='30'
						type='text'
						name='price_tag'
						class='widefat'
						value='<?php echo esc_attr($price_tag); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $before; ?>
				</td>
				<td>
					<input
						size='30'
						type='text'
						name='price_before'
						class='widefat'
						value='<?php echo esc_attr($price_before); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $after; ?>
				</td>
				<td>
					<input
						size='30'
						type='text'
						name='price_after'
						class='widefat'
						value='<?php echo esc_attr($price_after); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input
						type='checkbox'
						id='price_highlight'
						name='price_highlight'
						<?php if($price_highlight == 'on'): ?>
						checked
						<?php endif; ?>
					/>
					<label for='price_highlight'>
						<?php echo $highlight; ?>
					</label>
					<br />
					<small>
						<?php echo $this_option; ?>
					</small>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $description; ?>
				</td>
				<td>
					<?php wp_editor(
						$price_description,
						'price_description', array(
							'media_buttons'	=> false,
							'quicktags'			=> false,
							'teeny'					=> true,
						)); ?>
				</td>
			</tr>
		</table>
	</fieldset>
<?php }

function planeta_metabox_price_url_display()
{
	global $post;
	$price_url = get_post_meta($post->ID, 'price_url', true);
	$price_url_text = get_post_meta($post->ID, 'price_url_text', true);
	if(empty($price_url_text))
	{
		$price_url_text = esc_html__('Read More...', 'planeta');
	}

	$url = esc_html__('Button URL', 'planeta');
	$url_text = esc_html__('Button URL Text', 'planeta');
?>
	<fieldset>
		<legend class='screen-reader-text'>Price URL</legend>
		<table class='form-table'>
			<tr>
				<td class='first'>
					<?php echo $url; ?>
				</td>
				<td>
					<input
						size='30'
						type='url'
						name='price_url'
						class='widefat'
						value='<?php echo esc_attr($price_url); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $url_text; ?>
				</td>
				<td>
					<input
						size='30'
						type='text'
						name='price_url_text'
						class='widefat'
						value='<?php echo esc_attr($price_url_text); ?>'
					/>
				</td>
			</tr>
		</table>
	</fieldset>
<?php }

function planeta_add_metabox_price()
{
	add_meta_box(
		'planeta_metabox_price',
		'Price Information',
		'planeta_metabox_price_display',
		'price',
		'advanced',
		'high'
	);

	add_meta_box(
		'planeta_metabox_price_url',
		'Price Information',
		'planeta_metabox_price_url_display',
		'price',
		'advanced',
		'high'
	);
}

function planeta_metabox_price_save($post_id)
{
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);

	if($is_autosave || $is_revision)
	{
		return;
	}

	$post = get_post($post_id);
	if($post->post_type == 'price')
	{
		update_post_meta($post_id, 'price_highlight', $_POST['price_highlight']);
		if(array_key_exists('price_tag', $_POST))
		{
			update_post_meta($post_id, 'price_tag', $_POST['price_tag']);
		}
		if(array_key_exists('price_before', $_POST))
		{
			update_post_meta($post_id, 'price_before', $_POST['price_before']);
		}
		if(array_key_exists('price_after', $_POST))
		{
			update_post_meta($post_id, 'price_after', $_POST['price_after']);
		}
		if(array_key_exists('price_description', $_POST))
		{
			update_post_meta($post_id, 'price_description', $_POST['price_description']);
		}
		if(array_key_exists('price_url', $_POST))
		{
			update_post_meta($post_id, 'price_url', $_POST['price_url']);
		}
		if(array_key_exists('price_url_text', $_POST))
		{
			update_post_meta($post_id, 'price_url_text', $_POST['price_url_text']);
		}
	}
}
add_action('save_post', 'planeta_metabox_price_save');

function planeta_register_post_type_price()
{
	$labels_prices = array(
		'name'									=> esc_html__('Pricing', 'planeta'),
		'singular_name'					=> esc_html__('Price', 'planeta'),
		'add_new'								=> esc_html__('Add New Price', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit price', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No prices found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No prices found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Price updated.', 'planeta'),
	);
	$args_prices = array(
		'labels'								=> $labels_prices,
		'public'								=> true,
		'exclude_from_search'		=> true,
		'publicly_queryable'		=> false,
		'show_in_nav_menus'			=> false,
		'show_in_menu'					=> false,
		'show_in_rest'					=> false,
		'register_meta_box_cb'	=> 'planeta_add_metabox_price',
		'supports'							=> array(
			'title',
			'thumbnail',
		),
	);
	register_post_type('price', $args_prices);
}
add_action('init', 'planeta_register_post_type_price');

//Add to Submenu
function planeta_add_price_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Pricing', 'planeta'),
	esc_html__('Pricing', 'planeta'),
	'manage_options',
	'edit.php?post_type=price');
}
add_action('admin_menu', 'planeta_add_price_submenu');

add_filter('manage_price_posts_columns', 'planeta_price_columns');
function planeta_price_columns($columns)
{
	$columns['price_tag'] = esc_html__('Value and Currency', 'planeta');
	$columns['price_description'] = esc_html__('Description', 'planeta');
	unset($columns['date']);
	return $columns;
}

add_action('manage_price_posts_custom_column', 'custom_price_column', 10, 2);
function custom_price_column($column, $post_id)
{
	global $post;
	switch($column)
	{
		case 'price_tag':
			$price_tag = get_post_meta($post->ID, 'price_tag', true);
			echo esc_html($price_tag);
			break;

		case 'price_description':
			$price_tag = get_post_meta($post->ID, 'price_description', true);
			echo esc_html($price_tag);
			break;
	}
}

add_filter('manage_edit-price_sortable_columns', 'planeta_price_columns_sortable');
function planeta_price_columns_sortable($columns)
{
	$columns['price_tag'] = 'price_tag';
	$columns['price_description'] = 'price_description';
	return $columns;
}

?>
