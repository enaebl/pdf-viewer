<?php

namespace frontend\controllers;

class StaticController {

    private static $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public static function generateRandomString($length = 32) {
        $min = 0;
        $max = strlen(self::$alphabet) - 1;
        $res = '';
        for ($i = 0; $i < $length; $i++) {
            $random_index = random_int($min, $max);
            $random_char = substr(self::$alphabet, $random_index, 1);
            $res .= $random_char;
        }
        return $res;
    }

    public static function getFileExtension($file_name) {
        $res = substr($file_name, strrpos($file_name, '.'));
        return $res;
    }

}
