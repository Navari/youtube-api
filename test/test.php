<?php
    include_once "../vendor/autoload.php";
    use Youtube\YoutubeVideo;
    $youtube = new Youtube\YouTubeVideo();
    print_r ($youtube->getCommentsByVideoId('BPOEDacFb8k'));