<?php
namespace Youtube;

class Results
{
    public $pageInfo;
    public $items;
}

class Channel
{
    public $id;
    public $title;
    public $description;
    public $thumbnail;
    public $statistics;
}

class Video{
    public $id;
    public $title;
    public $description;
    public $channelId;
    public $channelTitle;
    public $categoryId;
    public $publishedAt;
    public $duration;
    public $thumbnail;
    public $statistics;
} 

class Comment{
    public $id;
    public $videoId;
    public $authorDisplayName;
    public $authorProfileImageUrl;
    public $authorChannelUrl;
    public $textComment;
    public $likeCount;
    public $publishedAt;
    public $canRate;
    public $canReply;
    public $totalReplyCount;
}