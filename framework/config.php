<?php
$config['secret_key'] = NONCE_KEY;
$config['secret_iv'] = NONCE_SALT;

// Redis
$config['redis_on'] = false;
$config['redis_key'] = 'web';
$config['redis_password'] = '';
$config['redis_client'] = ['scheme' => 'tcp', 'host' => '127.0.0.1'];
