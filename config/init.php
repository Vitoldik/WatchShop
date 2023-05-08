<?php

const DEBUG = true;
const ROOT_DIR = __DIR__ . '/..';
const PUBLIC_DIR = __DIR__ . '/../public';
const APP_DIR = __DIR__ . '/../app';
const VIEWS_DIR = APP_DIR . '/views';
const CORE_DIR = __DIR__ . '/../vendor/watchShop/core';
const LIBS_DIR = __DIR__ . '/../vendor/watchShop/core/libs';
const CACHE_DIR = __DIR__ . '/../tmp/cache';
const CONFIG_DIR = __DIR__ . '/../config';
const TMP_DIR = __DIR__ . '/../tmp';
const PAGES_DIR = __DIR__ . '/../public/pages';

const LAYOUT = 'watches';

const PROTOCOL = 'http://';
// http://localhost/public/index.php
$appPath = PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
// http://localhost/public/
$appPath = preg_replace("#[^/]+$#", '', $appPath);
// http://localhost
$appPath = str_replace('/public/', '', $appPath);

define("MAIN_URL", $appPath);

const ADMIN_PAGE = MAIN_URL . '/admin';

require_once __DIR__ . '/../vendor/autoload.php';