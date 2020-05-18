<?php

function send_contact_form_to_admin()
{
	$prefix = get_theme_mod('contact_form_prefix', '');
	$suffix = get_theme_mod('contact_form_suffix', '');
	$reception_email = get_theme_mod('contact_form_email', get_bloginfo('admin_email'));
	$site_mail = get_bloginfo('admin_email');

	$bad_parameters = esc_html__('Bad form parameters. Check the markup to make sure you are naming the inputs correctly.', 'planeta');
	$bad_email = esc_html__('Email address not formatted correctly.', 'planeta');
	$send_email_fail = esc_html__('Failed to send email. Check AJAX handler.', 'planeta');

	try
	{
		if(empty($_POST['name']) ||
			empty($_POST['email']) ||
			empty($_POST['message']) ||
			empty($_POST['subject']))
		{
      throw new Exception($bad_parameters);
    }

		if(!is_email($_POST['email'])) { throw new Exception($bad_email); }

		$name = $_POST['name'];
		$email = $_POST['email'];

    $headers = "From: ${name} <${email}>";
    $send_to = $reception_email;
    $subject = $prefix . $_POST['subject'] . $suffix;
		$message = $_POST['message'];

		if(wp_mail($send_to, $subject, $message, $headers))
		{
      echo json_encode(array('status' => 'success'));
      exit;
    }else {
      throw new Exception($send_email_fail);
    }

	} catch (Exception $e){
    echo json_encode(array('status' => 'error'));
    exit;
  }
}

add_action('wp_ajax_contact_send', 'send_contact_form_to_admin');
add_action('wp_ajax_nopriv_contact_send', 'send_contact_form_to_admin');

?>
