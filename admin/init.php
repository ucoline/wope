<?php
// Include filters
include admin_path('filters.php');

// Include init files
foreach (glob(admin_path('*/init.php')) as $filename) {
    include $filename;
}

// Include pages
autoload_files(admin_path('pages'));

// Include redis
if (\Libs\Redis::is_active()) {
    include admin_path('redis.php');
}
