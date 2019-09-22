<?php
namespace Youtube;

class Config {
    public static function options() {
        $options = new \stdClass;
        $options->ApiKey = "AIzaSyA5A20Crbo9G7GKsXYVBVOX1YLsHSjM6lU";
        $options->ClientId = "117917764812-6kvh009da5ebsp5dp30hod54td27lgk0.apps.googleusercontent.com";
        $options->ClientSecret = "eN3g7PyIZozRTru1RpLXTBTi";
        $options->RedirectUrl = "http://localhost/google-api-php-client/youtubevideo.php";
        $options->LanguageCode = "TR";
        return $options;
    }
}