<?php
namespace Youtube;

use Exception;
use Youtube\AuthService;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
require_once 'authservice.php';
require_once 'entities.php';

class YouTubeVideo extends AuthService
{
    private $youtube;

    public function __construct()
    {
        parent::__construct();
        $this->youtube = new \Google_Service_YouTube($this->client);
    }

    /**
     * [getMyChannels]
     * Oauth ile login olan kişinin kendi kanallarının listesini getirir
     * @return         [Results]
     */
    public function getMyChannels()
    {
        if ($this->auth() == true) {
            $channelResults = new Results;

            $response = $this->youtube->channels->listChannels('snippet,contentDetails,statistics',
                array('mine' => true)
            );
            $channelResults->pageInfo = $response->pageInfo;
            $channelResults->items = [];

            foreach ($response->items as $key => $channel) {
                $ch = new Channel();
                $ch->id = $channel->id;
                $ch->title = $channel->snippet->title;
                $ch->description = $channel->snippet->description;
                $ch->thumbnail = $channel->snippet->thumbnails->default->url;
                $ch->statistics = $channel->statistics;

                $channelResults->items[] = $ch;
            }
            return $channelResults;
        }
    }

    /**
     * [getChannelById]
     * Id si verilen kanalı getirir
     * @param  $id [videoId]
     * @return         [Results]
     */
    public function getChannelsById(string $id)
    {
        $channelResults = new Results;
        $response = $this->youtube->channels->listChannels('snippet,contentDetails,statistics',
            array(
                'id' => $id,
            )
        );

        $channelResults->pageInfo = $response->pageInfo;
        $channelResults->items = [];

        foreach ($response->items as $key => $channel) {
            $ch = new Channel();
            $ch->id = $channel->id;
            $ch->title = $channel->snippet->title;
            $ch->description = $channel->snippet->description;
            $ch->thumbnail = $channel->snippet->thumbnails->default->url;
            $ch->statistics = $channel->statistics;

            $channelResults->items[] = $ch;
        }
        return $channelResults;
    }

    /**
     * [getManagedByMeChannels]
     * Id si verilen benim yönetimimdeki kanalı getirir
     * @param  $id [videoId]
     * @return         [Results]
     */
    public function getManagedByMeChannels(string $id)
    {
        if ($this->auth() == true) {
            $channelResults = new Results;

            $response = $this->youtube->channels->listChannels('snippet,contentDetails,statistics',
                array(
                    'managedByMe' => true,
                    'onBehalfOfContentOwner' => $id,
                )
            );
            $channelResults->pageInfo = $response->pageInfo;
            $channelResults->items = [];

            foreach ($response->items as $key => $channel) {
                $ch = new Channel();
                $ch->id = $channel->id;
                $ch->title = $channel->snippet->title;
                $ch->description = $channel->snippet->description;
                $ch->thumbnail = $channel->snippet->thumbnails->default->url;
                $ch->statistics = $channel->statistics;

                $channelResults->items[] = $ch;
            }
            return $channelResults;
        }
    }

    /**
     * [getChannelByUsername]
     * Kullanıcı adına ait kanalları getirir
     * @param  $id [videoId]
     * @return         [Results]
     */
    public function getChannelsByUsername(string $username)
    {
        $channelResults = new Results;
        $response = $this->youtube->channels->listChannels('snippet,contentDetails,statistics',
            array(
                'forUsername' => $username,
            )
        );

        $channelResults->pageInfo = $response->pageInfo;
        $channelResults->items = [];

        foreach ($response->items as $key => $channel) {
            $ch = new Channel();
            $ch->id = $channel->id;
            $ch->title = $channel->snippet->title;
            $ch->description = $channel->snippet->description;
            $ch->thumbnail = $channel->snippet->thumbnails->default->url;
            $ch->statistics = $channel->statistics;

            $channelResults->items[] = $ch;
        }
        return $channelResults;
    }

    public function getVideosById(string $id)
    {
        $videoResults = new Results;
        $response = $this->youtube->videos->listVideos('snippet,contentDetails,statistics',
            array(
                'id' => $id,
            )
        );

        $videoResults->pageInfo = $response->pageInfo;
        $videoResults->items = [];

        foreach ($response->items as $key => $video) {
            $ch = new Video();
            $ch->id = $video->id;
            $ch->title = $video->snippet->title;
            $ch->description = $video->snippet->description;
            $ch->categoryId = $video->snippet->categoryId;
            $ch->channelId = $video->snippet->channelId;
            $ch->channelTitle = $video->snippet->channelTitle;
            $ch->publishedAt = $video->snippet->publishedAt;
            $ch->thumbnail = $video->snippet->thumbnails->default->url;
            $ch->duration = $this->parseTime($video->contentDetails->duration);
            $ch->statistics = $video->statistics;

            $videoResults->items[] = $ch;
        }
        return $videoResults;
    }

    public function getMyLikedVideos()
    {
        if ($this->auth() == true) {
            $videoResults = new Results;
            $response = $this->youtube->videos->listVideos('snippet,contentDetails,statistics',
                array(
                    'myRating' => 'like',
                )
            );

            $videoResults->pageInfo = $response->pageInfo;
            $videoResults->items = [];

            foreach ($response->items as $key => $video) {
                $ch = new Video();
                $ch->id = $video->id;
                $ch->title = $video->snippet->title;
                $ch->description = $video->snippet->description;
                $ch->categoryId = $video->snippet->categoryId;
                $ch->channelId = $video->snippet->channelId;
                $ch->channelTitle = $video->snippet->channelTitle;
                $ch->publishedAt = $video->snippet->publishedAt;
                $ch->thumbnail = $video->snippet->thumbnails->default->url;
                $ch->duration = $this->parseTime($video->contentDetails->duration);
                $ch->statistics = $video->statistics;

                $videoResults->items[] = $ch;
            }
            return $videoResults;
        }
    }

    /**
     * [rateVideo]
     * Id si verilen video yu like, dislike, none (daha önce yapılanı geri alır)
     * @param  $id [videoId]
     * @param  $type [like,dislike,none]
     * @return         [bool]
     */
    public function rateVideo(string $videoId, string $type = 'like')
    {
        if ($this->auth() == true) {
            $videoResults = new Results;
            $response = $this->youtube->videos->rate($videoId, $type);
            return true;
        }
    }

    public function getCommentsByVideoId(string $videoId)
    {
        $commentResults = new Results;
        $response = $this->youtube->commentThreads->listCommentThreads('snippet,replies',
            array(
                'videoId' => $videoId,
            )
        );

        $commentResults->pageInfo = $response->pageInfo;
        $commentResults->items = [];

        foreach ($response->items as $key => $comment) {
            $ch = new Comment();
            $ch->id = $comment->id;
            $ch->videoId = $comment->snippet->videoId;
            $ch->canReply = $comment->snippet->canReply;
            $ch->totalReplyCount = $comment->snippet->totalReplyCount;
            $ch->textComment = $comment->snippet->topLevelComment->snippet->textOriginal;
            $ch->authorDisplayName = $comment->snippet->topLevelComment->snippet->authorDisplayName;
            $ch->authorProfileImageUrl = $comment->snippet->topLevelComment->snippet->authorProfileImageUrl;
            $ch->authorProfileImageUrl = $comment->snippet->topLevelComment->snippet->authorProfileImageUrl;
            $ch->authorChannelUrl = $comment->snippet->topLevelComment->snippet->authorChannelUrl;
            $ch->likeCount = $comment->snippet->topLevelComment->snippet->likeCount;
            $ch->publishedAt = $comment->snippet->topLevelComment->snippet->publishedAt;
            $ch->canRate = $comment->snippet->topLevelComment->snippet->canRate;

            $commentResults->items[] = $ch;
        }
        return $commentResults;
    }

    public function getCommentsByChannelId(string $channelId)
    {
        $commentResults = new Results;
        $response = $this->youtube->commentThreads->listCommentThreads('snippet,replies',
            array(
                'channelId' => $channelId,
            )
        );

        $commentResults->pageInfo = $response->pageInfo;
        $commentResults->items = [];

        foreach ($response->items as $key => $comment) {
            $ch = new Comment();
            $ch->id = $comment->id;
            $ch->videoId = $comment->snippet->videoId;
            $ch->canReply = $comment->snippet->canReply;
            $ch->totalReplyCount = $comment->snippet->totalReplyCount;
            $ch->textComment = $comment->snippet->topLevelComment->snippet->textOriginal;
            $ch->authorDisplayName = $comment->snippet->topLevelComment->snippet->authorDisplayName;
            $ch->authorProfileImageUrl = $comment->snippet->topLevelComment->snippet->authorProfileImageUrl;
            $ch->authorProfileImageUrl = $comment->snippet->topLevelComment->snippet->authorProfileImageUrl;
            $ch->authorChannelUrl = $comment->snippet->topLevelComment->snippet->authorChannelUrl;
            $ch->likeCount = $comment->snippet->topLevelComment->snippet->likeCount;
            $ch->publishedAt = $comment->snippet->topLevelComment->snippet->publishedAt;
            $ch->canRate = $comment->snippet->topLevelComment->snippet->canRate;

            $commentResults->items[] = $ch;
        }
        return $commentResults;
    }

    public function insertCommentThreadToVideo(string $videoId, string $commentMessage)
    {
        if ($this->auth() == true) {
            $videoResults = new Results;
            $commentThread = new Google_Service_YouTube_CommentThread();
            $commentThreadSnippet = new Google_Service_YouTube_CommentThreadSnippet();
            $comment = new Google_Service_YouTube_Comment();
            $commentSnippet = new Google_Service_YouTube_CommentSnippet();
            $commentSnippet->setTextOriginal($commentMessage);
            $comment->setSnippet($commentSnippet);
            $commentThreadSnippet->setTopLevelComment($comment);
            $commentThreadSnippet->setVideoId($videoId);
            $commentThread->setSnippet($commentThreadSnippet);

            $response = $this->youtube->commentThreads->insert('snippet', $commentThread);
            return true;
        }
    }

    public function insertCommentToCommentThread(string $commentThreadId, string $commentMessage)
    {
        if ($this->auth() == true) {
            $videoResults = new Results;
            $comment = new Google_Service_YouTube_Comment();
            $commentSnippet = new Google_Service_YouTube_CommentSnippet();
            $commentSnippet->setParentId($commentThreadId);
            $commentSnippet->setTextOriginal($commentMessage);
            $comment->setSnippet($commentSnippet);

            $response = $this->youtube->comments->insert('snippet', $comment);
            return true;
        }
    }

    public function updateComment(string $commentId, string $commentMessage)
    {
        if ($this->auth() == true) {
            $videoResults = new Results;
            $comment = new Google_Service_YouTube_Comment();
            $comment->setId($commentId);
            $commentSnippet = new Google_Service_YouTube_CommentSnippet();
            $commentSnippet->setTextOriginal($commentMesage);
            $comment->setSnippet($commentSnippet);

            $response = $this->youtube->comments->update('snippet', $comment);
            return true;
        }
    }

    public function markAsSpamComment(string $commentId)
    {
        if ($this->auth() == true) {            
            $response = $this->youtube->comments->markAsSpam($commentId);
            return true;
        }
    }

}