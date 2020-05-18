<?php

function planeta_metabox_team_display()
{
	global $post;
	$member_name = get_post_meta($post->ID, 'member_name', true);
	$member_position = get_post_meta($post->ID, 'member_position', true);
	$member_description = get_post_meta($post->ID, 'member_description', true);

	$name = esc_html__('Name', 'planeta');
	$position = esc_html__('Position', 'planeta');
	$description = esc_html__('Description', 'planeta');
?>
	<fieldset>
		<legend class='screen-reader-text'>Member Information</legend>
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
						name='member_name'
						class='widefat'
						value='<?php echo esc_attr($member_name); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>
					<?php echo $position; ?>
				</td>
				<td>
					<input
						required
						size='30'
						type='text'
						name='member_position'
						class='widefat'
						value='<?php echo esc_attr($member_position); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $description; ?>
				</td>
				<td>
					<?php wp_editor(
						$member_description,
						'member_description', array(
							'media_buttons'	=> false,
							'quicktags'			=> false,
							'teeny'					=> true,
						)); ?>
				</td>
			</tr>
		</table>
	</fieldset>
<?php }

function planeta_metabox_team_social_display()
{
	global $post;
	$member_social_facebook = get_post_meta($post->ID, 'member_social_facebook', true);
	$member_social_twitter = get_post_meta($post->ID, 'member_social_twitter', true);
	$member_social_instagram = get_post_meta($post->ID, 'member_social_instagram', true);
	$member_social_linkedin = get_post_meta($post->ID, 'member_social_linkedin', true);
	$member_social_skype = get_post_meta($post->ID, 'member_social_skype', true);
	$member_social_github = get_post_meta($post->ID, 'member_social_github', true);

	$member_social_info = esc_html__('Member Social Media', 'planeta');

?>

	<fieldset>
	<legend class='screen-reader-text'>
		<?php echo $member_social_info; ?>
	</legend>
		<table class='form-table'>
			<tr>
				<td class='first'>Facebook</td>
				<td>
					<input
						size='30'
						type='url'
						name='member_social_facebook'
						class='widefat'
						value='<?php echo esc_url($member_social_facebook); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>Twitter</td>
				<td>
					<input
						size='30'
						type='url'
						name='member_social_twitter'
						class='widefat'
						value='<?php echo esc_url($member_social_twitter); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>Instagram</td>
				<td>
					<input
						size='30'
						type='url'
						name='member_social_instagram'
						class='widefat'
						value='<?php echo esc_url($member_social_instagram); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>LinkedIn</td>
				<td>
					<input
						size='30'
						type='url'
						name='member_social_linkedin'
						class='widefat'
						value='<?php echo esc_url($member_social_linkedin); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>Skype</td>
				<td>
					<input
						size='30'
						type='url'
						name='member_social_skype'
						class='widefat'
						value='<?php echo esc_url($member_social_skype); ?>'
					/>
				</td>
			</tr>
			<tr>
				<td class='first'>GitHub</td>
				<td>
					<input
						size='30'
						type='url'
						name='member_social_github'
						class='widefat'
						value='<?php echo esc_url($member_social_github); ?>'
					/>
				</td>
			</tr>
		</table>
	</fieldset>

<?php
}


function planeta_add_metabox_team()
{
	add_meta_box(
		'planeta_metabox_team',
		esc_html__('Member Information', 'planeta'),
		'planeta_metabox_team_display',
		'team',
		'advanced',
		'high'
	);
	add_meta_box(
		'planeta_metabox_team_social',
		esc_html__('Member Social Media', 'planeta'),
		'planeta_metabox_team_social_display',
		'team',
		'advanced',
		'low'
	);
}

function planeta_metabox_team_save($post_id)
{
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);

	if($is_autosave || $is_revision)
	{
		return;
	}

	$post = get_post($post_id);
	if($post->post_type == 'team')
	{
		if(array_key_exists('member_name', $_POST))
		{
			update_post_meta($post_id, 'member_name', $_POST['member_name']);
		}
		if(array_key_exists('member_position', $_POST))
		{
			update_post_meta($post_id, 'member_position', $_POST['member_position']);
		}
		if(array_key_exists('member_description', $_POST))
		{
			update_post_meta($post_id, 'member_description', $_POST['member_description']);
		}
		if(array_key_exists('member_social_facebook', $_POST))
		{
			update_post_meta($post_id, 'member_social_facebook', $_POST['member_social_facebook']);
		}
		if(array_key_exists('member_social_twitter', $_POST))
		{
			update_post_meta($post_id, 'member_social_twitter', $_POST['member_social_twitter']);
		}
		if(array_key_exists('member_social_instagram', $_POST))
		{
			update_post_meta($post_id, 'member_social_instagram', $_POST['member_social_instagram']);
		}
		if(array_key_exists('member_social_linkedin', $_POST))
		{
			update_post_meta($post_id, 'member_social_linkedin', $_POST['member_social_linkedin']);
		}
		if(array_key_exists('member_social_skype', $_POST))
		{
			update_post_meta($post_id, 'member_social_skype', $_POST['member_social_skype']);
		}
		if(array_key_exists('member_social_github', $_POST))
		{
			update_post_meta($post_id, 'member_social_github', $_POST['member_social_github']);
		}
	}
}
add_action('save_post', 'planeta_metabox_team_save');

function planeta_register_post_type_team()
{
	$labels_teams = array(
		'name'									=> esc_html__('Team', 'planeta'),
		'singular_name'					=> esc_html__('Member', 'planeta'),
		'add_new'								=> esc_html__('Add New Member', 'planeta'),
		'add_new_item'					=> esc_html__('Add New Item', 'planeta'),
		'edit_item'							=> esc_html__('Edit team', 'planeta'),
		'search_items'					=> esc_html__('Search Items', 'planeta'),
		'not_found'							=> esc_html__('No members found.', 'planeta'),
		'not_found_in_trash'		=> esc_html__('No members found in Trash.', 'planeta'),
		'item_updated'					=> esc_html__('Member updated.', 'planeta'),
	);
	$args_teams = array(
		'labels'								=> $labels_teams,
		'public'								=> true,
		'menu_icon'							=> 'dashicons-groups',
		'exclude_from_search'		=> true,
		'publicly_queryable'		=> false,
		'show_in_nav_menus'			=> false,
		'show_in_menu'					=> false,
		'show_in_rest'					=> false,
		'register_meta_box_cb'	=> 'planeta_add_metabox_team',
		'supports'							=> array(
			'thumbnail',
		),
	);
	register_post_type('team', $args_teams);
}
add_action('init', 'planeta_register_post_type_team');

//Add to Submenu
function planeta_add_team_submenu()
{
add_submenu_page(
	'planeta_welcome',
	esc_html__('Team', 'planeta'),
	esc_html__('Team', 'planeta'),
	'manage_options',
	'edit.php?post_type=team');
}
add_action('admin_menu', 'planeta_add_team_submenu');

add_filter('manage_team_posts_columns', 'planeta_team_columns');
function planeta_team_columns($columns)
{
	$columns['member_name'] = esc_html__('Name', 'planeta');
	$columns['member_position'] = esc_html__('Position', 'planeta');
	$columns['member_description'] = esc_html__('Description', 'planeta');
	unset($columns['title']);
	unset($columns['date']);
	return $columns;
}

add_action('manage_team_posts_custom_column', 'custom_team_column', 10, 2);
function custom_team_column($column, $post_id)
{
	global $post;
	switch($column)
	{
		case 'member_name':
			$member_name = get_post_meta($post->ID, 'member_name', true);
			echo esc_html($member_name);
			break;

		case 'member_position':
			$member_position = get_post_meta($post->ID, 'member_position', true);
			echo esc_html($member_position);
			break;

		case 'member_description':
			$member_description = get_post_meta($post->ID, 'member_description', true);
			echo esc_html($member_description);
			break;
	}
}

add_filter('manage_edit-team_sortable_columns', 'planeta_team_columns_sortable');
function planeta_team_columns_sortable($columns)
{
	$columns['member_name'] = 'member_name';
	$columns['member_position'] = 'member_position';
	$columns['member_description'] = 'member_description';
	return $columns;
}

?>
