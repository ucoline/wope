<?php
$output = form_notify();
$type = input_post('form_type');

if (wp_verify_nonce(request_value('ajax-form-xr'), 'ajax-form')) {
    $verify_nonce = true;
} elseif (wp_verify_nonce(request_value('ajax_action'), 'ajax-action-nonce')) {
    $verify_nonce = true;
} else {
    $verify_nonce = false;
}

if ($type == 'contact-form' && $verify_nonce) {
    $fullname = input_post('fullname');
    $email = input_post('email');
    $phone = input_post('phone');
    $subject = input_post('subject');
    $message = input_post('message');
    $recaptcha = input_post('g-recaptcha-response');

    if (!$fullname) {
        $output['msg'] = __('Please enter your full name.', 'wope');
    } elseif (!$subject) {
        $output['msg'] = __('Please enter a subject.', 'wope');
    } elseif (!$email) {
        $output['msg'] = __('Please enter your email address.', 'wope');
    } elseif ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $output['msg'] = __('Please enter a valid email address.', 'wope');
    } elseif (!$message) {
        $output['msg'] = __('Please enter a message.', 'wope');
    } elseif (empty($recaptcha)) {
        $output['msg'] = __('Please confirm google captcha.', 'wope');
    } else {
        $recaptcha_secret_key = Theme::get_option('recaptcha_secret_key');
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret_key . '&response=' . $recaptcha);
        $responseData = json_decode($verifyResponse);

        if ($responseData != null && $responseData->success) {
            $title = __('Contact Message', 'wope');
            $args = array(
                'title' => $title,
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            );

            $to = 'info@domain.com';
            $subject = $title . ': ' . $subject;
            $body = inc_view('mailing/contact-form', $args, true);
            $headers = array('Content-Type: text/html; charset=UTF-8');

            if (wp_mail($to, $subject, $body, $headers)) {
                $output = form_notify('success');
                $output['msg'] = __('Your message has been sent. We will get back to you as soon as possible.', 'wope');
            }
        } else {
            $output['msg'] = __('Robot verification failed, please try again.', 'wope');
        }
    }

    echo json_encode($output);
    exit();
}
