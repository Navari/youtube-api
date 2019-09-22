# Youtube Data APIs Client Library for PHP!

Hi! I'm your first Markdown file in **StackEdit**. If you want to learn about StackEdit, you can read me. If you want to play with Markdown, you can edit me. Once you have finished with me, you can create new files by opening the **file explorer** on the left corner of the navigation bar.


# Gereksinimler

[PHP 5.4.0 or higher](https://www.php.net/)

## Google Developer Console

1.  [Google Developer Console](https://console.cloud.google.com/)  a giriş yapın.
2.  Henüz yoksa yeni bir  **Proje**  tanımlayın ve Sol üst taraftaki logonun yanından bu projeyi seçin.
3.  Sol menüden  **Api Hizmetler -> Kimlik Bilgileri**ne gelin
4.  "**Kimlik bilgileri oluştur**" butonuna tıklayın.
5.  **Api anahtarı**  oluşturun.
6.  "**Kimlik bilgileri oluştur**" butonuna tekrar tıklayın.
7.  **Oauth**  istemci kimliği oluşturun.
8.  Sol menüden  **Api Hizmetler -> Kimlik Bilgileri**ne gelin
.env dosyanıza aşağıdaki bilgileri ekleyin 
> YOUTUBE_API_KEY = "YOUR APİ KEY"
> YOUTUBE_CLIENT_SECRET="YOUR CLİENT SECRET"
> YOUTUBE_CLIENT_ID="YOUR CLIENT ID"
> YOUTUBE_REDIRECT_URL="YOUR REDIRECT URL"
## Composer

Projenize dahil etmek için 
>composer require navari/youtube-api

## Örnek Kullanımlar

        /*
    * Oauth ile login olan kişinin kendi kanallarının listesini getirir
    */
    public function getMyChannels()
    /*
    * Id si verilen kanal listesini getirir
    */
    public function getChannelsById(string $id)
    /*
    * Oauth ile login olan kişinin kendi yönetme yetkisi olan kanalları getirir
    */
    public function getManagedByMeChannels(string $id)
    /*
    * Kullanıcı adına ait kanal listesini getirir
    */
    public function getChannelsByUsername(string $username)
    /*
    * Id si verilen video listesini getirir
    */
    public function getVideosById(string $id)
    /*
    * Login olan kişinin beğendiği video listesini getirir
    */
    public function getMyLikedVideos()
    /*
    * Login olan kişi tarafından id si verilen videoya like, dislike, none yapılabilir. (none bir önceki yapılan işlemi geri alır)
    */
    public function rateVideo(string $videoId, string $type = 'like')
    /*
    * Id si verilen vvideodaki yorum listesini getirir
    */
    public function getCommentsByVideoId(string $videoId)
    /*
    * Id si verilen kanaldaki yorum listesini getirir
    */
    public function getCommentsByChannelId(string $channelId)
    /*
    * Videoya yorum konusu girilir
    */
    public function insertCommentThreadToVideo(string $videoId, string $commentMessage)
    /*
    * Yoruma yorum yazdırır
    */
    public function insertCommentToCommentThread(string $commentThreadId, string $commentMessage)
    /*
    * Login olan kişinin var olan bir yorumu günceler
    */
    public function updateComment(string $commentId, string $commentMessage)
    /*
    * Login olan kişi tarafından yorum için spam bildirimi yapar
    */
    public function markAsSpamComment(string $commentId)
    //....
    //....
    }
