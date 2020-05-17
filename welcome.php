<?php

function planeta_get_welcome_page()
{
	$welcome = esc_html__("Welcome to the Planeta Theme!", 'planeta');
	$goto_customizer = esc_html__("If you haven't already, go to Customizer and...", 'planeta');
	$install_kirki = esc_html__("Install the Kirki Framework to unlock the power of this theme!", 'planeta');
	$choose_preset = esc_html__("Choose your Theme Preset", 'planeta');
	$edit_sections = esc_html__("Edit Frontpage Sections to suit your needs", 'planeta');
	$dont_panic = esc_html__("Lost? Don't panic, read...", 'planeta');
	$documentation = esc_html__("Documentation", 'planeta'); ?>
<div id='welcome-container'>
	<h1>
		<?php echo $welcome; ?>
		<small class='version-notice'>alpha</small>
	</h1>

	<p class='ol-notice'><?php echo $goto_customizer; ?></p>
	<ol>
		<li><?php echo $install_kirki; ?></li>
		<li><?php echo $choose_preset; ?></li>
		<li><?php echo $edit_sections; ?></li>
	</ol>
	<div class='docs-container'>
	<p class='docs-notice'><?php echo $dont_panic; ?></p>
		<a
				href='http://www.example.com'
				target='_blank'
				class='button button-primary'
				name='Documentation'>
			<?php echo $documentation; ?>
		</a>
	</div>
</div>
<?php
} ?>
