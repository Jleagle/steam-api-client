<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Enums\SteamFormatEnum;
use Jleagle\SteamClient\Exceptions\SteamException;

abstract class Steam
{
  protected $_format = SteamFormatEnum::JSON;
  protected $_apiKey = null;

  /**
   * @return string
   */
  abstract protected function _getService();

  /**
   * @param string $apiKey
   */
  public function __construct($apiKey = null)
  {
    $this->setApiKey($apiKey);
  }

  /**
   * @param string $apiKey
   *
   * @return $this
   */
  public function setApiKey($apiKey)
  {
    $this->_apiKey = $apiKey;
    return $this;
  }

  /**
   * @return $this
   */
  public function setFormatJson()
  {
    $this->_format = SteamFormatEnum::JSON;
    return $this;
  }

  /**
   * @return $this
   */
  public function setFormatXml()
  {
    $this->_format = SteamFormatEnum::XML;
    return $this;
  }

  /**
   * @return $this
   */
  public function setFormatVdf()
  {
    $this->_format = SteamFormatEnum::VDF;
    return $this;
  }

  /**
   * @return $this
   */
  public function setFormatCsv()
  {
    $this->_format = SteamFormatEnum::CSV;
    return $this;
  }

  protected function _get($path = null, $query = [], $apiKey = true)
  {
    if($path)
    {
      $query['format'] = $this->_format;

      if($apiKey && $this->_apiKey)
      {
        $query['key'] = $this->_apiKey;
      }

      $path = 'http://api.steampowered.com/' . $this->_getService() . '/' .
        $path . '?' . http_build_query($query);
    }
    else
    {
      $path = http_build_query($query);
      $path = 'http://store.steampowered.com/api/appdetails?' . $path;
    }

    $context = stream_context_create(
      [
        'http' => [
          'method' => 'GET'
        ]
      ]
    );

    $result = @file_get_contents($path, false, $context);
    if($result === false)
    {
      throw new SteamException();
    }

    return json_decode($result, true);
  }
}
