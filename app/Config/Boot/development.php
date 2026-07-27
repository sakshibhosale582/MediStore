<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | In development, we want to show as many errors as possible to help
 | make sure they don't make it to production. And save us hours of
 | painful debugging.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
 |--------------------------------------------------------------------------
 | DEBUG BACKTRACES
 |--------------------------------------------------------------------------
 | If true, this constant will tell the error screens to display debug
 | backtraces along with the other error information.
 */
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 */
defined('CI_DEBUG') || define('CI_DEBUG', true);
