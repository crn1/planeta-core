<?php

function planeta_metabox_testimonial_author_display()
{
	global $post;
	$author_name = get_post_meta($post->ID, 'author_name', true);
	$author_about = get_post_meta($post->ID, 'author_about', true);

	$name = esc_html__('Name', 'planeta');
	$john_doe = esc_html__('John Doe', 'planeta');
	$about = esc_html__('About', 'planeta');
	$web_developer = esc_html__('Web Developer', 'planeta');
?>
	<fieldset>
		<legend class='screen-reader-text'>Testimonial Author</legend>
		<table class='form-table'>
			<tr>
				<td class='first'>
					<?php echo $name; ?>
				</td>
				<td>
					<input
						required
						size='30'
						type='text'
						name='author_name'
						class='widefat'
						placeholder='<?php echo $john_doe; ?>'
						value='<?php echo esc_attr($author_name); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $about; ?>
				</td>
				<td>
					<input
						size='30'
						type='text'
						name='author_about'
						class='widefat'
						placeholder='<?php echo $web_developer; ?>'
						value='<?php echo esc_attr($author_about); ?>'
					/>
				</td>
			</tr>
		</table>
	</fieldset>
<?php }

function planeta_metabox_testimonial_text_display()
{
	global $post;
	$testimonial_excerpt = get_post_meta($post->ID, 'testimonial_excerpt', true);
	$testimonial_full = get_post_meta($post->ID, 'testimonial_full', true);

	$excerpt = esc_html__('Excerpt', 'planeta');

	$about = esc_html__('About', 'planeta');
	$web_developer = esc_html__('Web Developer', 'planeta');
	$full_testimonial = esc_html__('Full Testimonial', 'planeta');
?>
	<fieldset>
		<legend class='screen-reader-text'>Testimonial Text</legend>
		<table class='form-table'>
			<tr>
				<td class='first'>
					<?php echo $excerpt; ?>
				</td>
				<td>
					<input
						required
						size='30'
						type='text'
						name='testimonial_excerpt'
						class='widefat'
						value='<?php echo esc_attr($testimonial_excerpt); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $full_testimonial; ?>
				</td>
				<td>
					<?php wp_editor(
						$testimonial_full,
						'testimonial_full', array(
							'media_buttons'	=> false,
							'quicktags'			=> false,
							'teeny'					=> true,
						)); ?>
				</td>
			</tr>
		</table>
	</fieldset>
<?php }

function planeta_add_metabox_testimonial()
{
	add_meta_box(
		'planeta_metabox_testimonial_author',
		'Author',
		'planeta_metabox_testimonial_author_display',
		'testimonial',
		'advanced',
		'high'
	);

	add_meta_box(
		'planeta_metabox_testimonial_text',
		'Testimonial',
		'planeta_metabox_testimonial_text_display',
		'testimonial',
		'advanced',
		'high'
	);
}

function planeta_metabox_testimonial_save($post_id)
{
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);

	if($is_autosave || $is_revision)
	{
		return;
	}

	$post = get_post($post_id);
	if($post->post_type == 'testimonial')
	{
		if(array_key_exists('author_name', $_POST))
		{
			update_post_meta($post_id, 'author_name', $_POST['author_name']);
		}
		if(array_key_exists('author_about', $_POST))
		{
			update_post_meta($post_id, 'author_about', $_POST['author_about']);
		}
		if(array_key_exists('testimonial_excerpt', $_POST))
		{
			update_post_meta($post_id, 'testimonial_excerpt', $_POST['testimonial_excerpt']);
		}
		if(array_key_exists('testimonial_full', $_POST))
		{
			update_post_meta($post_id, 'testimonial_full', $_POST['testimonial_full']);
		}
	}
}
add_action('save_post', 'planeta_metabox_testimonial_save');

function planeta_register_post_type_testimonial()
{
	$labels_testimonials = array(
		'name'									=> esc_html__('Testimonials', 'planeta'),
		'singular_name'					=> esc_html__('Testimonial', 'planeta'),
		'add_new'								=> esc_html__('Add New Testimonial', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit Testimonial', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No testimonials found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No testimonials found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Testimonial updated.', 'planeta'),
	);
	$args_testimonials = array(
		'labels'								=> $labels_testimonials,
		'public'								=> true,
		'exclude_from_search'		=> true,
		'publicly_queryable'		=> false,
		'show_in_nav_menus'			=> false,
		'show_in_menu'					=> false,
		'show_in_rest'					=> false,
		'register_meta_box_cb'	=> 'planeta_add_metabox_testimonial',
		'supports'							=> array(
			'thumbnail',
		),
	);
	register_post_type('testimonial', $args_testimonials);
}
add_action('init', 'planeta_register_post_type_testimonial');

//Add to Submenu
function planeta_add_testimonial_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Testimonials', 'planeta'),
	esc_html__('Testimonials', 'planeta'),
	'manage_options',
	'edit.php?post_type=testimonial');
}
add_action('admin_menu', 'planeta_add_testimonial_submenu');

add_filter('manage_testimonial_posts_columns', 'planeta_testimonial_columns');
function planeta_testimonial_columns($columns)
{
	$columns['author_name'] = esc_html__('Author', 'planeta');
	$columns['testimonial_excerpt'] = esc_html__('Excerpt', 'planeta');
	unset($columns['title']);
	unset($columns['date']);
	return $columns;
}

add_action('manage_testimonial_posts_custom_column', 'custom_testimonial_column', 10, 2);
function custom_testimonial_column($column, $post_id)
{
	global $post;
	switch($column)
	{
		case 'author_name':
			$author_name = get_post_meta($post->ID, 'author_name', true);
			echo esc_html($author_name);
			break;

		case 'testimonial_excerpt':
			$testimonial_excerpt = get_post_meta($post->ID, 'testimonial_excerpt', true);
			echo esc_html($testimonial_excerpt);
			break;
	}
}

add_filter('manage_edit-testimonial_sortable_columns', 'planeta_testimonial_columns_sortable');
function planeta_testimonial_columns_sortable($columns)
{
	$columns['author_name'] = 'author_name';
	$columns['testimonial_excerpt'] = 'testimonial_excerpt';
	return $columns;
}

?>
