<?php
namespace Youtube;

class Config {
    public static function options() {
        $options = new \stdClass;
        $options->ApiKey = env('YOUTUBE_API_KEY');
        $options->ClientId = env('YOUTUBE_CLIENT_ID');
        $options->ClientSecret = env('YOUTUBE_CLIENT_SECRET');
        $options->RedirectUrl = env('YOUTUBE_REDIRECT_URL');
        $options->LanguageCode = "TR";
        return $options;
    }
}