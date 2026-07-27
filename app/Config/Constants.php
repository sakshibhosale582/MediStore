<?php

defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6);
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);

// MediStore custom constants
defined('UPLOAD_PATH')       || define('UPLOAD_PATH', ROOTPATH . 'public/uploads/');
defined('PRESCRIPTION_PATH') || define('PRESCRIPTION_PATH', ROOTPATH . 'public/uploads/prescriptions/');
defined('MEDICINE_PATH')     || define('MEDICINE_PATH', ROOTPATH . 'public/uploads/medicines/');
defined('BANNER_PATH')       || define('BANNER_PATH', ROOTPATH . 'public/uploads/banners/');
defined('AVATAR_PATH')       || define('AVATAR_PATH', ROOTPATH . 'public/uploads/avatars/');

defined('TAX_RATE')          || define('TAX_RATE', 5);
defined('DELIVERY_CHARGE')     || define('DELIVERY_CHARGE', 50);
defined('FREE_DELIVERY_MIN')   || define('FREE_DELIVERY_MIN', 500);
