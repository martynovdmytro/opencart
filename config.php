<?php
// HTTP
define('HTTP_SERVER', 'http://opencart.local/');

// HTTPS
define('HTTPS_SERVER', 'http://opencart.local/');

// DIR
define('DIR_APPLICATION', '/Users/froze/dev/opencart.local/catalog/');
define('DIR_SYSTEM', '/Users/froze/dev/opencart.local/system/');
define('DIR_IMAGE', '/Users/froze/dev/opencart.local/image/');
define('DIR_STORAGE', '/Users/froze/dev/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '1111');
define('DB_DATABASE', 'opencart');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');