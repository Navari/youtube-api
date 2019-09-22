<?php
namespace Youtube;
use Exception;

session_start();

/**
 *  Api Service For Auth
 */
class AuthService {
	protected $client;
    protected $ytLanguage;
    
	public function __construct() {
        $config = Config::options();

		$this->client = new \Google_Client();
		$this->client->setClientId($config->ClientId);
		$this->client->setClientSecret($config->ClientSecret);
		$this->client->setDeveloperKey($config->ApiKey);
		$this->client->setRedirectUri($config->RedirectUrl);
		$this->client->setScopes([
			'https://www.googleapis.com/auth/youtube',
		]);
		$this->client->setAccessType('offline');
		$this->client->setPrompt('consent');
		$this->ytLanguage = $config->LanguageCode;
    }
    
	public function getToken($code) {
		try {
			$this->client->authenticate($code);
			$token = $this->client->getAccessToken();
			return $token;
		} catch (\Google_Service_Exception $e) {
			throw new Exception($e->getMessage(), 1);
		} catch (\Google_Exception $e) {
			throw new Exception($e->getMessage(), 1);
		} catch (\Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
    }
    
	public function auth() {
		try
		{
            $auth = false;
    
			if (isset($_SESSION['access_token'])) {
                $auth = true;
                $this->client->setAccessToken($_SESSION['access_token']);
                return true;
            }else{
                if (!isset($_GET['code'])) {
                    $authUrl = $this->client->createAuthUrl();
                    echo "Open this link in your browser: <a href='", $authUrl, "'>link</a>";
                    return false;
                }else{
                    $this->getToken($_GET['code']);
                    $_SESSION['access_token'] = $this->client->getAccessToken();
                    return true;
                }
            }

            return false;
		} catch (\Google_Service_Exception $e) {
			throw new Exception($e->getMessage(), 1);
		} catch (\Google_Exception $e) {
			throw new Exception($e->getMessage(), 1);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
    }
    
	public function setAccessToken($google_token = null) {
		try {
			if (!is_null($google_token)) {
				$this->client->setAccessToken($google_token);
			}
			if (!is_null($google_token) && $this->client->isAccessTokenExpired()) {
				$refreshed_token = $this->client->getRefreshToken();
				$this->client->fetchAccessTokenWithRefreshToken($refreshed_token);
				$newToken = $this->client->getAccessToken();
				$newToken = json_encode($newToken);
			}
			return !$this->client->isAccessTokenExpired();
		} catch (\Google_Service_Exception $e) {
			throw new Exception($e->getMessage(), 1);
		} catch (\Google_Exception $e) {
			throw new Exception($e->getMessage(), 1);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
    }

    public function parseTime($time) {
		$tempTime = str_replace("PT", " ", $time);
		$tempTime = str_replace('H', " Hours ", $tempTime);
		$tempTime = str_replace('M', " Minutes ", $tempTime);
		$tempTime = str_replace('S', " Seconds ", $tempTime);
		return $tempTime;
	}
}