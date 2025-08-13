<?php
namespace SIM\HEICTOJPEG;
use SIM;

const MODULE_VERSION		= '8.1.0';

DEFINE(__NAMESPACE__.'\MODULE_PATH', plugin_dir_path(__DIR__));

DEFINE(__NAMESPACE__.'\MODULE_SLUG', strtolower(basename(dirname(__DIR__))));

require( MODULE_PATH  . 'lib/vendor/autoload.php');