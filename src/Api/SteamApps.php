<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Exceptions\SteamException;
use Jleagle\SteamClient\Responses\AppsListAppResponse;
use Jleagle\SteamClient\Responses\ServerResponse;
use Jleagle\SteamClient\Responses\VersionCheckResponse;

class AbstractSteamApps extends AbstractSteam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'ISteamApps';
  }

  /**
   * @return AppsListAppResponse[]
   * @throws SteamException
   */
  public function getAppList()
  {
    $path = 'GetAppList/v2';
    $data = $this->_get($path);

    $items = [];
    foreach($data['applist']['apps'] as $app)
    {
      $items[] = new AppsListAppResponse($app);
    }
    return $items;
  }

  /**
   * @param string $ip
   * @return ServerResponse[]
   * @throws SteamException
   */
  public function getServersAtAddress($ip)
  {
    $path = 'GetServersAtAddress/v1';
    $query = ['addr' => $ip];

    $data = $this->_get($path, $query);

    $items = [];
    foreach($data['response']['servers'] as $server)
    {
      $items[] = new ServerResponse($server);
    }
    return $items;
  }

  /**
   * @param int $appId
   * @param int $version
   * @return VersionCheckResponse
   * @throws SteamException
   */
  public function upToDateCheck($appId, $version)
  {
    $path = 'UpToDateCheck/v1';
    $query = ['appid' => $appId, 'version' => $version];

    $data = $this->_get($path, $query);

    return new VersionCheckResponse($data['response']);
  }
}
