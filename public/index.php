<?php

use watchShop\App;

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS_DIR . '/functions.php';

new App();

throw new Exception('Страница не найдена!', 404);