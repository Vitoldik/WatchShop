<?php

function debug($arr) {
    echo  '<pre>' . print_r($arr, true) . '</pre>';
}

function redirect($http = false) {
    if ($http) {
        $redirect = $http;
    } else {
        // получаем предыдущий адрес пользователя, если его нет, то редеректим на главную
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : MAIN_URL;
    }

    header("Location: $redirect");
    exit();
}

function escapeSpecialChars($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES);
}