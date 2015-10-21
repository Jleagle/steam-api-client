<?php
namespace Jleagle\SteamClient\Api;

use Curl\Curl;
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

  /**
   * @param string $path
   * @param array  $query
   * @param bool   $apiKey
   *
   * @return array
   *
   * @throws SteamException
   */
  protected function _get($path = null, $query = [], $apiKey = true)
  {
    $curl = new Curl();

    if($path)
    {
      $query['format'] = $this->_format;

      if($apiKey && $this->_apiKey)
      {
        $query['key'] = $this->_apiKey;
      }

      $service = $this->_getService();
      $path = 'http://api.steampowered.com/' . $service . '/' . $path;
    }
    else
    {
      $path = 'http://store.steampowered.com/api/appdetails';
    }

    $curl->get($path, $query);

    if($curl->error)
    {
      throw new SteamException($curl->error_message, $curl->http_status_code);
    }
    else
    {
      return json_decode($curl->response, true);
    }
  }
}
