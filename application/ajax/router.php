<?php
header("Content-Type: application/json; charset=utf-8");

$output = form_notify();

$xr = input_get('xr');
$post = input_post('ajax');

if ($xr) {
    include_app_file('ajax/'. $xr);

    echo json_encode($output);
    exit();
}

if ($post) {
    include_app_file('ajax/'. $post);

    echo json_encode($output);
    exit();
}

echo json_encode($output);
exit();
