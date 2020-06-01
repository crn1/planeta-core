<?php

function planeta_get_welcome_page()
{
	$welcome = esc_html__("Welcome to the Planeta Theme!", 'planeta');
	$goto_customizer = esc_html__("If you haven't already...", 'planeta');
	$install_plugins = esc_html__("Install the necessary plugins", 'planeta');
	$choose_demo = esc_html__("Import your demo at Appearance -> Import Demo Data", 'planeta');
	$dont_panic = esc_html__("Lost? Don't panic, read...", 'planeta');
	$documentation = esc_html__("Documentation", 'planeta'); ?>
<div id='welcome-container'>
	<h1>
		<?php echo $welcome; ?>
		<small class='version-notice'>beta</small>
	</h1>

	<p class='ol-notice'><?php echo $goto_customizer; ?></p>
	<ol>
		<li><?php echo $install_plugins; ?></li>
		<li><?php echo $choose_demo; ?></li>
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
<?php }
?>
