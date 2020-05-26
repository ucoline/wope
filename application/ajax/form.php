<?php
$output = form_notify();
$type = input_post('form-type');

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
        $output['msg'] = lexicon('form_error_fullname');
    } else if (!$subject) {
        $output['msg'] = lexicon('form_error_subject');
    } else if (!$message) {
        $output['msg'] = lexicon('form_error_message');
    } else if (!$email) {
        $output['msg'] = lexicon('form_error_email');
    } else if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $output['msg'] = lexicon('form_error_valid_email');
    } else if (empty($recaptcha)) {
        $output['msg'] = lexicon('form_error_recaptcha');
    } else {
        $recaptcha_secret_key = get_option('recaptcha_secret_key');
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='. $recaptcha_secret_key .'&response='.$recaptcha);
        $responseData = json_decode($verifyResponse);

        if($responseData->success) {
            $args = array(
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            );

            $to = 'info@teknorot.com';
            $subject = 'İletişim Formu: '. $subject;
            $body = theme_view('inc/mailing/contact-form', $args, true);
            $headers = array('Content-Type: text/html; charset=UTF-8');

            if (wp_mail($to, $subject, $body, $headers)) {
                $output = form_notify('success');
                $output['msg'] = lexicon('form_success');
            }
        } else {
            $output['msg'] = 'Robot verification failed, please try again.';
        }
    }

    echo json_encode($output);
    exit();
}
