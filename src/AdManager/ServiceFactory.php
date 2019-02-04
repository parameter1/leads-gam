<?php

namespace Limit0\AdManager;

use Google\AdsApi\AdManager\AdManagerServices;
use Google\AdsApi\AdManager\AdManagerSessionBuilder;
use Google\AdsApi\Common\Configuration;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\AdsApi\Common\AdsSession;

class ServiceFactory {
  /**
   * @var AdsSession
   */
  private $session;

  /**
   * @var AdManagerServices
   */
  private $services;

  /**
   *
   */
  public function __construct()
  {
    $this->services = new AdManagerServices();
  }

  /**
   *
   */
  public function service($class)
  {
    if (!$this->session) {
      $config = $this->config();
      $credential = $this->credential($config);
      $this->session = $this->session($config, $credential);
    }
    return $this->services->get($this->session, $class);
  }

  /**
   * @return Configuration
   */
  private function config() {
    return new Configuration([
      'AD_MANAGER' => [
        'networkCode'     => getenv('NETWORK_CODE'),
        'applicationName' => 'Lead Management',
      ],
      'OAUTH2' => [
        'jsonKeyFilePath' => realpath(getenv('JSON_KEY_FILE_PATH')),
        'scopes'          => 'https://www.googleapis.com/auth/dfp',
      ],
    ]);
  }

  /**
   * @return ServiceAccountCredentials
   */
  private function credential(Configuration $config)
  {
    return (new OAuth2TokenBuilder())
      ->from($config)
      ->build()
    ;
  }

  /**
   *
   */
  private function session(Configuration $config, ServiceAccountCredentials $credential)
  {
    return (new AdManagerSessionBuilder())
      ->from($config)
      ->withOAuth2Credential($credential)
      ->build()
    ;
  }
}
