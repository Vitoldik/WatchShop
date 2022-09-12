<?php

use watchShop\App;

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS_DIR . '/functions.php';

new App();
print_array(App::$app->getProperties());