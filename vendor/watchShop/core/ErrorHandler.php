<?php

namespace watchShop;

class ErrorHandler {

    public function __construct() {
        error_reporting(DEBUG ? -1 : 0);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($ex) {
        $this->logErrors($ex->getMessage(), $ex->getFile(), $ex->getLine());
        $this->displayError('Исключение', $ex->getMessage(), $ex->getFile(), $ex->getLine(), $ex->getCode());
    }

    protected function logErrors($message = '', $file = '', $line = '') {
        error_log('[' . date('Y-m-d H:i:s') . '] ' .
            "Текст ошибки: $message | Файл: $file | Строка: $line\n", 3, TMP_DIR . '/errors.log');
    }

    protected function displayError($number, $text, $file, $line, $response = 404) {
        http_response_code($response);

        if (!DEBUG) {
            if ($response == 404) {
                require PAGES_DIR . '/errors/404.php';
                die;
            }

            require PAGES_DIR . '/errors/prod.php';
        } else {
            require PAGES_DIR . '/errors/dev.php';
        }

        die;
    }
}