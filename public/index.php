<?php

use watchShop\App;

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS_DIR . '/functions.php';
require_once CONFIG_DIR . '/routes.php';

new App();

debug(\watchShop\Router::getRoutes());